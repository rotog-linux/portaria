<?php

namespace lib;

class Verificacoes
{
    /**
     * Recebe o campo Data do banco e o formata para DD/MM/AAAA
     */
    public static function ajustarData(string $dataOrigem)
    {
        if ($dataOrigem == '' || $dataOrigem == 'NULL'){
            return '';
        }
        
        $data = explode('-', $dataOrigem);
        $dataAjustada = $data[2] . '/' . $data[1] . '/' . $data[0];
        return ($dataAjustada == '00/00/0000') ? '' : $dataAjustada;
    }

    /**
     * Recebe o campo Hora do banco e o formata para HH:MM
     */
    public static function ajustarHora(string $dataHoraOrigem)
    {
        if ($dataHoraOrigem == '' || $dataHoraOrigem == 'NULL'){
            return '';
        }

        $dataHora = explode(' ', $dataHoraOrigem);
        $hora     = explode(':', $dataHora[1]);
        $horaAjustada = $hora[0] . ':' . $hora[1];

        return ($horaAjustada != '00:00') ? $horaAjustada : '';
    }

    /**
     * Proteção contra textos maliciosos
     */
    public static function verificarString(string $texto) {
        $texto = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $texto);
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $texto = addslashes($texto);
        return $texto;
    }

    /**
     * Criação do token CSRF guardando na seção
     */
    public static function criarCsrf()
    {
        $_SESSION['csrf'] = sha1(date('d-m-Y H-i-s'));
    }

    /**
     * Formatar o CNPJ
     */
    public static function montarCnpj(string $cnpj)
    {
        return substr($cnpj, 0, 2) . '.' . 
               substr($cnpj, 2, 3) . '.' .
               substr($cnpj, 5, 3) . '/' .
               substr($cnpj, 8, 4) . '-' .
               substr($cnpj, 12, 2);
    }

    /**
     * Verificar se a data é válida.
     * Receber a data dessa forma: YYYY-mm-dd
     */
    public static function dataValida(string $data)
    {
        $data_array = explode('-', $data);
        $ano = $data_array[0];
        $mes = $data_array[1];
        $dia = $data_array[2];

        return checkdate($mes, $dia, $ano);
    }

    /**
     * Verificar se um horário é válido.
     * Receber o horário dessa forma: hh:mm
     */
    public static function horaValida(string $horario)
    {
        $hora_array = explode(':', $horario);
        $hora = $hora_array[0];
        $minuto = $hora_array[1];

        $retorno = true;

        if ($hora > 23 || $minuto > 59){
            $retorno = false;
        }

        return $retorno;
    }
}