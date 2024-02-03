function atualizarUrl(url){
	url=getHrefSemDominio(url);
	history.replaceState({url:url},null,url);
}

function criarUrl(url){
	url=getHrefSemDominio(url);
	history.pushState({url:url},'',url);
}

function gatilhoDoHistórico(){
	$(window).on('popstate',function(event) {
		var estado = event.originalEvent.state;	
		if(estado){
			var sessao=lerNaSessão(estado.url);
			// 12) restaura página ao navegar
			restaurarOEstado(sessao);
		}
	});
}

function gatilhoDosLinks(sel){
	if(sel){
		sel=sel+' a[x-spa]';
	}else{
		sel='a[x-spa]';
	}	
	$(sel).on('click',function(event){
		if(event.ctrlKey || event.shiftKey){
			// abre o link em outra janela sem processar
			return true;
		}else{		
			// processa o link
			event.preventDefault();
			// 1) atualizar o estado atual no histórico
			atualizarUrl(document.location);
			// 2) salvar html,href,título,scroll da página
			var estado=salvarNaSessão();
			// 3) extrair a template do href
			var href=$(this).attr('href');
			var hrefSemDominio=getHrefSemDominio(href);			
			var template=rotas[getRotaDoHref(href)];
			// 4) exibir a template com a classe ph
			$('#chaplin').addClass('ph');
			$('#chaplin').html(template);
			// 5) criar o novo estado no histórico	
			criarUrl(href);			
			// 6) tentar baixar os dados da página
			var sessao=lerNaSessão(hrefSemDominio);
			if(sessao){
				restaurarOEstado(sessao);
			}else{
				$.getJSON(href,function(data){
					// 8) renderizar a página com os dados
					document.title=data.title;
					var html=chaplin(template,data);
					$('#chaplin').html(html);
					gatilhoDosLinks('#chaplin');
					// 9) remover a classe ph
					removerClassePh();
					// 10) salvar sessão da nova página				
					var novoEstado={
						html:html,
						url:hrefSemDominio,
						scroll:0,
						title:data.title
					};
					salvarNaSessão(novoEstado);
				})
					.fail(function(){
					// 7) erro 404 = restaurar estado
					alert("404 not found");//dá pra exibir a template 404
					history.back();
				});	
			}
		}
	});
}

function getRotaDoHref(href){
	var rota=href.split(SITE_URL)[1];
	rota=rota.split('/')[1];
	if(rota==''){
		rota='home';
	}
	return rota;
}

function getHrefSemDominio(href){
	href=href.toString();
	href=href.split(SITE_DOMAIN)[1];
	if(href==''){
		href='/';
	}
	return href;
}

function lerNaSessão(href){
	var value=sessionStorage.getItem(href);
	if(value){
		return JSON.parse(value);
	}else{
		return false;
	}
}

function removerClassePh(){
	if($('#chaplin').hasClass('ph')){
		$('#chaplin').removeClass('ph');	
	}
}

function restaurarOEstado(estado){
	if(estado){
		// history.back();
		$('#chaplin').html(estado.html);
		document.title=estado.title;
		$(window).scrollTop(estado.scroll);
		removerClassePh();
	}
}

function salvarNaSessão(estado){
	if(!estado){
		var html=$('#chaplin').html();
		var hrefSemDominio=getHrefSemDominio(document.location);
		var scroll=$(window).scrollTop();
		var title=document.title;	
		var estado={
			html:html,
			url:hrefSemDominio,
			scroll:scroll,
			title:title
		};
	}
	sessionStorage.setItem(estado.url,JSON.stringify(estado));
	return estado;
}

$(function(){
	// 11) gatilhos do links (fix) e histórico	
	gatilhoDoHistórico();
	gatilhoDosLinks();
});