<table width="500" cellpadding="5" cellspacing="0">
	<tr>
    	<td width="100" align="right">Nome:</td>
        <td><b><?php echo $name; ?></td>
    </tr>
    <tr>
        <td width="100" align="right">Setor:</td>
        <td><b><?php echo $setor; ?></td>
    </tr>
    <tr>
        <td width="100" align="right">Cidade:</td>
        <td><?php echo $city; ?></td>
    </tr>
    <tr>
        <td width="100" align="right">Estado:</td>
        <td><?php echo $state; ?></td>
    </tr>
    <tr>
    	<td width="100" align="right">E-mail:</td>
        <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
    </tr>
    <tr>
    	<td width="100" align="right">Telefone:</td>
        <td><?php echo $phone; ?></td>
    </tr>
    <tr>
    	<td width="100" align="right">Mensagem:</td>
        <td><?php echo $message; ?></td>
    </tr>
</table>
