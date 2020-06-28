<?php
declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Entity\User as NUser;
use dcr\facade\Db;
use dcr\Safe;
use Respect\Validation\Validator as v;
use app\Model\Concerns\Model;

/**
 * Class User
 * @package app\Model
 */
class User extends NUser implements Model
{
    /**
     * 验证数据
     * @PrePersist @PreUpdate
     */
    public function validate($entity)
    {

        //加上帐套id
        $usernameLimit = $this->getUsernameLengthLimit();
        $passwordLimit = $this->getPasswordLengthLimit();
        //dd($type);
        $stringValidator = v::stringType()->length($usernameLimit['min'], $usernameLimit['max']);
        if (!$stringValidator->validate($entity->getUsername())) {
            throw new \Exception('用户名长度不符合');
        }
        if (strlen($this->getPassword())) {
            $stringValidator = v::stringType()->length($passwordLimit['min'], $passwordLimit['max']);
            if (!$stringValidator->validate($entity->getPassword())) {
                throw new \Exception('密码长度不符合');
            }
        }
        if (!v::in([1, 2])->validate($entity->getSex())) {
            throw new \Exception('性别选择有问题');
        }
    }


    /**
     * 获取用户名长度限制
     */
    public function getUsernameLengthLimit()
    {
        return array('min' => 2, 'max' => 20);
    }

    /**
     * 获取密码长度限制
     */
    public function getPasswordLengthLimit()
    {
        return array('min' => 6, 'max' => 20);
    }

    /**
     * 添加编辑会员
     * @param array $userInfo 格式如下
     * $userInfo = array(
     * 'username' => post('username'), 必填
     * 'password' => post('password'), 必填
     * 'sex' => post('sex'), 必填 1或2
     * 'mobile' => post('mobile'),
     * 'tel' => post('tel'),
     * 'note' => post('note'),
     * );
     * @param string $type 添加还是编辑
     * @return array
     * @throws \Exception
     */
    public function addEditUser(array $userInfo, string $type = 'add')
    {
        $type = $type ? $type : 'add';

        //判断是否存在
        if ('add' == $type) {
            $info = container('em')->getRepository('\app\Model\Entity\User')->findBy(array('username' => $userInfo['username']));
            if ($info) {
                return array('ack' => 0, 'msg' => '用户已经存在');
            }
        }

        $ztId = session('ztId');
        $addUserId = session('userId');
        //开始存数据
        if ('edit' == $type) {
            $clsUser = container('em')->find('\app\Model\Entity\User', $userInfo['id']);
        } else {
            $clsUser = new NUser();
        }
        $dataTimeNow = new \DateTime("now");
        $clsUser->setAddTime($dataTimeNow);
        $clsUser->setUsername($userInfo['username']);
        $clsUser->setUpdateTime($dataTimeNow);
        $clsUser->setSex($userInfo['sex']);
        $clsUser->setMobile($userInfo['mobile']);
        $clsUser->setTel($userInfo['tel']);
        $clsUser->setNote($userInfo['note']);
        $clsUser->setIsSuper($userInfo['is_super']);
        $clsUser->setIsApproval(1);
        $clsUser->setZtId($ztId);

        if ($userInfo['password']) {
            $clsUser->setPassword(Safe::_encrypt($userInfo['password']));
        }
        if ('add' == $type) {
            $clsUser->setAddUserId($addUserId);
        } elseif ('edit' == $type) {
            $clsUser->setEditUserId(session('userId'));
        }

        $this->validate($clsUser);

        DB::beginTransaction();
        if ('add' == $type) {
            container('em')->persist($clsUser);
        }
        container('em')->flush();
        $userId = $clsUser->getId();

        $roles = $userInfo['roles'];

        if ('edit' == $type) {
            //开始添加用户
            DB::delete('user_role_config', "u_id={$userId} and zt_id={$ztId}");
        }

        //开始更新用户角色
        if ($roles) {
            foreach ($roles as $roleKey) {
                //dd($roleKey);
                //先判断有没有
                $clsUserRole = new \app\Model\Entity\UserRoleConfig();
                $clsUserRole->setAddTime($dataTimeNow);
                $clsUserRole->setUpdateTime($dataTimeNow);
                $clsUserRole->setAddUserId($addUserId);
                $clsUserRole->setZtId($ztId);
                $clsUserRole->setUId($userId);
                $clsUserRole->setUrId($roleKey);
                container('em')->persist($clsUserRole);
                container('em')->flush();
            }
        }
        DB::commit();

        return Admin::commonReturn(array('ack' => 1));
    }
}
