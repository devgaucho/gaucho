<?php
namespace Gaucho;

class Chaplin
{

    function render($str, $data)
    {
        return $this->renderFromString($str, $data);
    }

    function renderFromString($str, $data)
    {
        // {{#nome_da_variavel}} ... {{/nome_da_variavel}}
        $blockPattern = '/{{#([a-zA-Z0-9_]+)}}(.*?){{\/\1}}/s';
        // {{&nome_da_variavel}} ou {{nome_da_variavel}}
        $variablePattern = '/{{(?:&)?([a-zA-Z0-9_]+)}}/';
        // renderiza os loops
        $fnLoop = function ($matches) use ($data) {
            $blockName = $matches[1];
            $blockContent = $matches[2];
            if (isset($data[$blockName]) and is_array($data[$blockName])) {
                // processa para cada variável
                $blockResult = '';
                foreach ($data[$blockName] as $item) {
                    $blockResult .= $this->render($blockContent, $item);
                }
                return $blockResult;
            } else {
                // / remove o bloco se ele não existe
                return '';
            }
        };
        $str = preg_replace_callback($blockPattern, $fnLoop, $str);
        // renderiza as variáveis simples
        $fnVar = function ($matches) use ($data) {
            $variableName = $matches[1];
            if (isset($data[$variableName])) {
                $value = $data[$variableName];
            } else {
                $value = $matches[0];
            }
            if (strpos($matches[0], '{{&') === 0) {
                return $value;
            } else {
                return htmlspecialchars($value);
            }
        };
        $str = preg_replace_callback($variablePattern, $fnVar, $str);
        return $str;
    }

    function renderFromFile($filename, $data)
    {
        if (file_exists($filename)) {
            $template = file_get_contents($filename);
            return $this->renderFromString($template, $data);
        } else {
            die(htmlentities($filename) . ' not found');
        }
    }
}
