<?php
declare(strict_types=1);


namespace dcr;

class Annotations
{
    private $returnData;
    private $annotationsList;
    private $runTime;
    private $className;
    private $methodName;

    /**
     * @return mixed
     */
    public function getReturnData()
    {
        return $this->returnData;
    }

    /**
     * @return mixed
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param $annotations
     */
    public function setAnnotations($annotations)
    {
        $this->className = $annotations->getClass();
        $this->methodName = $annotations->getMethod();
    }

    /**
     * @param mixed $runTime
     */
    public function setRunTime($runTime)
    {
        $this->runTime = $runTime;
    }

    /**
     * @param mixed $returnData
     */
    public function setReturnData($returnData)
    {
        $this->returnData = $returnData;
    }

    /**
     * @param mixed $annotationsList
     */
    public function setAnnotationsList($annotationsList)
    {
        $this->annotationsList = $annotationsList;
    }

    public function getAllowAnnotations(): array
    {
        return array('log', 'cache');
    }

    public function getRealAnnotationName($annotationName): string
    {
        $arr = explode('_', $annotationName);
        return $arr[0];
    }

    /**
     * 解析注解列表
     */
    public function exec()
    {
        $allowAnnotation = $this->getAllowAnnotations();
        foreach ($this->annotationsList as $key => $parameter) {
            $annotationName = $this->getRealAnnotationName($key);
            if (!in_array($annotationName, $allowAnnotation)) {
                continue;
            }
            $annotationClassName = "\\dcr\\annotation\\" . ucfirst($annotationName);
            $cls = new $annotationClassName;
            $cls->setAnnotations($this); //把记录好的信息传过去
            $cls->setParameter($parameter);
            $cls->handler();
        }
    }
}
