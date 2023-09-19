<?php
namespace App\Models;

use TypeError;

class Metodo
{

    public $exectime = 0;
    public $paramString = '';

    /** Mensagem de erro de execução, se houver */
    public $execError = null;

    /** resultado da execução do método */
    public $exec = null;

    public function __construct($className, $methodName)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->preencherDefaultParams();
    }

    /**
     * Pega os inputs do form e transforma em params e paramsString
     */
    public function atribuirParams($inputs)
    {
        $params = [];
        $paramString = '';

        foreach ($inputs as $k => $v) {
            $v_array = json_decode($v, true); // array é passado como json

            if (is_numeric($v) || $v === '0') {
                // é um número, nesse caso sempre inteiro
                $paramString .= 'n_' . $v . ', ';
                $params[$k] = intval($v);

            } elseif (empty($v) || $v == 'null') {
                // vazio - vamos colocar o valor default
                $paramString .= 'empty, ';
                $params[$k] = $this->defaultParams[$k];

            } elseif (str_starts_with($v, '[') && json_last_error() === JSON_ERROR_NONE) {
                // é um json valido, vamos atribuir o array corespondente
                $paramString .= 'j_' . $v . ', ';
                $params[$k] = $v_array;

            } else {
                //string normal
                $paramString .= 's_' . $v . ', ';
                $params[$k] = $v;
            }
        }
        $this->params = $params;
        $this->paramString = substr($paramString, 0, -2);
        return true;
    }

    /**
     * a classe reflection ainda é usada nas views
     */
    public function obterReflection()
    {
        return new \ReflectionMethod($this->className, $this->methodName);
    }

    /**
     * Recupera da reflection e retorna os valores default dos parâmetros
     *
     * Se não possuir parâmetros, devemos atribuir []
     */
    public function preencherDefaultParams()
    {
        $methodReflection = $this->obterReflection();
        $this->isPublic = $methodReflection->isPublic();

        foreach ($methodReflection->getParameters() as $i => $p) {
            $params[$p->name] = $p->isDefaultValueAvailable()? $p->getDefaultValue() : '';
            $types[$p->name] = $p->getType() ? $p->getType()->getName() : '';
        }
        $this->defaultParams = $params ?? [];
        $this->types = $types ?? [];
        return true;
    }

    /**
     * retorna os parâmetros formatado para a view
     */
    public function obterParams()
    {
        $params = isset($this->params) ? $this->params : $this->defaultParams;
        $ret = [];
        foreach ($params as $k => $p) {
            if ($p == $this->defaultParams[$k]) {
                $p = '';
            }
            $ret[] = is_array($p) ? json_encode($p) : $p;
        }
        return $ret;
    }

    /**
     * Executa o método medindo tempo de execução
     */
    public function exec()
    {
        $className = $this->className;
        $metodo = $this->methodName;
        $params = array_values($this->params);
        $exectime = -microtime(true);

        try {
            $exec = $className::$metodo(...$params);
        } catch (TypeError $e) {
            // echo 'Exceção capturada: ',  $e->getMessage(), "\n";
            $this->execError = $e->getMessage();
            $exec = '';//$e->getMessage();
        }
        $exectime += microtime(true);
        $this->exectime = number_format($exectime, 3);
        $this->exec = $exec;
        return $exec;
    }
}
