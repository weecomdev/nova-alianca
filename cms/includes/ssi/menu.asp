<img src="../interface/layout_topo_esq.jpg">
<% If Session("logado") Then %>

<div id="menu">

    <img src="../interface/layout_menu_topo.jpg"><br>

    <b onClick="menuShow(0)">Conte�do</b>
        <div>
            <a href="../vinicola/listar.asp">Vin�cola</a><br>
			<a href="../download/listar.asp">Downloads</a><br>
            <a href="../mundo/listar.asp">Mundo do vinho</a><br>
            <a href="../video/listar.asp">V�deos</a><br>
            <a href="../faq/listar.asp">D�vidas</a><br>
            <a href="../onde/listar.asp">Onde comprar</a><br>
            <a href="../representante/listar.asp">Representantes</a>
        </div>

    <b onClick="menuShow(1)">Produtos</b>
        <div>
            <a href="../produto_linha/listar.asp">Linhas de produto</a><br>
            <a href="../produto_tipo/listar.asp">Tipos de produto</a><br>
            <a href="../produto/listar.asp">Produtos</a>
		</div>
        
    <b onClick="menuShow(2)">News</b>
        <div>
            <a href="../agenda/listar.asp">Not�cias</a><br>
            <a href="../premio/listar.asp">Premia��es</a><br>
			<a href="../imprensa/listar.asp">Dicas</a><br>
		</div>


    <b onClick="menuShow(3)">Imagens</b>
        <div>
            <a href="../abertura/listar.asp">Abertura</a><br>
            <a href="../home/listar.asp">P�gina inicial</a><br>
            <a href="../engine_galeria/listar.asp">Galeria das se��es</a>
		</div>

    <b onClick="menuShow(4)">Confraria</b>
        <div>
            <a href="../confraria/listar.asp">Confraria</a><br>
            <a href="../galeria/listar.asp">Galeria de fotos</a>
		</div>
       
    <b onClick="menuShow(5)">Contato</b>
        <div>
            <a href="../formulario/listar.asp">Formul�rios</a><br>
            <a href="../contato/listar.asp">Contato</a><br>
            <a href="../endereco/listar.asp">Endereco</a><br>
		</div>

    <b onClick="menuShow(6)">Usu�rio</b>
        <div>
            <a href="../usuarios/editar.asp">editar dados</a>
        </div>

   <img src="../interface/layout_menu_base.jpg"><br>

</div>

<% End If %>


