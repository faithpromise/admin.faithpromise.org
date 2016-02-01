<?php

namespace App\FaithPromise\FellowshipOne\Models;

use App\FaithPromise\FellowshipOne\FellowshipOne;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class Base implements \ArrayAccess, Arrayable {

    protected $attributes = [];
    protected $values = [];
    protected $client;
    protected $context_id;

    public function __construct(FellowshipOne $client, $data = null) {

        $this->setClient($client);

        if ($data !== null) {
            $this->load($data);
        }

    }

    /**
     * @return FellowshipOne
     */
    public function getClient() {
        return $this->client;
    }

    public function setClient(FellowshipOne $client) {
        $this->client = $client;
    }

    public function load($data) {

        foreach ($this->attributes as $model_property => $f1_field) {

            $data_field = is_array($f1_field) ? $f1_field[0] : $f1_field;
            $model_class = is_array($f1_field) ? $f1_field[1] : null;

            if (array_key_exists($data_field, $data)) {

                /* Define the set method to set the property */
                $method = 'set' . $model_property;

                /* If property value is to be a model */
                if ($model_class) {

                    /* If we have a collection of values, define a collection */
                    if (is_array($data[$data_field]) && is_array(array_values($data[$data_field])[0])) {

                        $collection = new Collection();

                        foreach(array_values($data[$data_field])[0] as $item) {
                            $value = new $model_class($this->getClient(), $item);
                            $collection->push($value);
                        }
                        $this->$method($collection);

                    /* Otherwise it's a single record */
                    } else {
                        $this->$method(new $model_class($this->getClient(), $data[$data_field]));
                    }

                /* Otherwise, property value is to be used as is - a string or array */
                } else {
                    $this->$method($data[$data_field]);
                }

            }
        }

    }



    public function toJson() {
        return json_encode($this->values);
    }

    public function toArray() {

        $result = $this->values;

        foreach($result as &$value) {
            if (is_object($value)) {
                /** @noinspection PhpUndefinedMethodInspection */
                $value = $value->toArray();
            }
        }

        return $result;
    }

    public function offsetExists($offset) {
        return array_key_exists($offset, $this->attributes);
    }

    public function offsetGet($offset) {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->set($offset, $value);
    }

    public function offsetUnset($offset) {
        if (array_key_exists($offset, $this->attributes)) {
            unset($this->attributes[$offset]);
        }
    }

    public function __toString() {
        return $this->toJson();
    }

    public function __call($name, $args = []) {

        if (preg_match('/^set/', strtolower($name))) {
            $attr = strtolower(preg_replace('/^set/', '', $name));
            if (array_search($attr, array_map('strtolower', array_keys($this->attributes))) !== false) {
                $this->values[$attr] = $args[0];
            }

            return $this;
        }

        if (preg_match('/^get/', strtolower($name))) {
            $attr = strtolower(preg_replace('/^get/', '', $name));
            if (array_search($attr, array_map('strtolower', array_keys($this->attributes))) !== false) {
                return $this->values[$attr];
            }
        }

        return null;

    }
}