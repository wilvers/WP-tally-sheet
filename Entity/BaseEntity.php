<?php

/**
 * Description of BaseEntity
 *
 * @author pwilvers
 */
class BaseEntity implements JsonSerializable {

    public function jsonSerialize() {
        return $this->prepareForJson();
    }

    /**
     *
     * @return \stdClass
     */
    public function prepareForJson() {
        $object = new \stdClass();
        foreach ($this as $key => $value) {
            $key = $this->jsonCleanKey($key);
            if (is_object($value)) {
                $object->{$key} = $value->asJson();
            } elseif (is_array($value)) {
                $object->{$key} = $this->jsonTraverseArray($value);
            } else {
                $object->{$key} = $value;
            }
        }
        return $object;
    }

    protected function jsonCleanKey($key) {
        if ('_' === substr($key, 0, 1)) {
            return substr($key, 1);
        }
        return $key;
    }

    protected function jsonTraverseArray($array) {
        $list = array();
        foreach ($array as $k => $v) {
            $k = $this->jsonCleanKey($k);
            if (is_object($v)) {
                $list[] = $v->prepareForJson();
            } else {
                $list[$k] = $v;
            }
        }
        return $list;
    }

}
