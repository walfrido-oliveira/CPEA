<?php

const DEFAULT_PAGINATE_PER_PAGE = 10;
const DEFAULT_ORDER_BY_COLUMN = "created_at";
const DEFAULT_ASCENDING = "desc";
const SECONDS = "1000";

if (! function_exists('mask'))
{
    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}

if (! function_exists('months'))
{
    function months()
    {
        return [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];
    }
}

if (! function_exists("defaultSaveMessagemNotification"))
{
    function defaultSaveMessagemNotification()
    {
        return array(
            'message' => __('Dados salvos com sucesso!'),
            'alert-type' => 'success'
        );
    }
}

if (! function_exists("setNotification"))
{
    function setNotification($msg, $type = "success")
    {
        return array(
            'message' => $msg,
            'alert-type' => $type
        );
    }
}

if (! function_exists('flash'))
{
    function flash($message, $type = "success")
    {
        Session::flash('message', __($message));
        Session::flash('alert-type', $type);
    }
}
