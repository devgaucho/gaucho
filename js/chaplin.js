function chaplin(str,data) {
    // {{#nome_da_variavel}} ... {{/nome_da_variavel}}
    const blockPattern=/{{#([a-zA-Z0-9_]+)}}(.*?){{\/\1}}/gs;
    
    // {&nome_da_variavel}} ou {{nome_da_variavel}}
    const variablePattern=/{{(?:&)?([a-zA-Z0-9_]+)}}/g;

    // função pra escapar o html
    var escapeHtml=function(str) {
        const htmlEntities={
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        };
        return str.replace(/[&<>"']/g,function(match){
            return htmlEntities[match];
        });
    };

    // renderiza os blocos
    var fnBlock=function(match,blockName,blockContent){
        var dataIsArray=Array.isArray(data[blockName]);
        if(data[blockName]!==undefined && dataIsArray){
            // processa o bloco para cada variável
            let blockResult='';
            data[blockName].forEach(function(item){
                blockResult+=chaplin(blockContent,item);
            });
            return blockResult;
        } else {
            // remove o bloco se ele não existe
            return '';
        }
    };
    str=str.replace(blockPattern,fnBlock);    

    // renderiza as variáveis simples
    var fnVar=function(match,variableName){
        const value=data[variableName];
        if(value!==undefined){
            if(match.startsWith('{{&')){
                return value;
            }else{
                return escapeHtml(value);
            }
        }else{
            return match;
        }
    };
    str=str.replace(variablePattern,fnVar);

    return str;
}