<?php
/**
/** Adicionando Colunas Ordenáveis por custom field (meta_value) no admin do WordPress

* @Author Quebrando a Cabeça
* @Author URL http://quebrandoacabeca.com
* @Post URL http://quebrandoacabeca.com/adicionar-coluna-custom-field-no-admin/
*/?>


	// ADD COLUNA DE CUSTOM FIELD AO ADMIN
	add_filter('manage_edit-portifolio_columns', 'minha_coluna'); // Altere o 'portifolio' pelo nome do seu custom-post-type
    function minha_coluna($colunas) { // Inicia a função
    $colunas['servico'] = 'Serviços'; // Cria coluna Serviços
	$colunas['cliente'] = 'Cliente'; // Cria coluna Cliente
    return $colunas; // Exibe as colunas
    }
	// ADD META VALUE NAS COLUNAS SERVIÇOS E CLIENTES DO ADMIN DE PORTIFOLIO
	add_action('manage_posts_custom_column', 'exibir_minha_coluna');
    function exibir_minha_coluna($nome) { // Inicia a função
    global $post;
    switch ($nome) {
    case 'servico': // Custom field name (meta_key)
    $servico = get_post_meta($post->ID, 'servico', true); // chama custom field value servico
    echo $servico; // exibe custom field value
    }
	switch ($nome) {
    case 'cliente': // Custom field name (meta_key)
    $cliente = get_post_meta($post->ID, 'cliente', true); // chama custom field value cliente
    echo $cliente; // exibe custom field value
    }
    }
	
	
	add_filter( 'manage_edit-portifolio_sortable_columns', 'ordenar_minha_coluna' ); // Altere o 'portifolio' pelo nome do seu custom-post-type
 
function ordenar_minha_coluna( $post_colunas ) { // Inicia a função
    $post_colunas = array(
        'servico' => 'servico', // Ordenação por servico
        'cliente' => 'cliente' // Ordenação por cliente
        );
 
    return $post_colunas;
}

add_filter( 'parse_query', 'ordenar_coluna_meta_value' );
 
function ordenar_coluna_meta_value($query) { // Inicia a função
    global $pagenow;
    if (is_admin() && $pagenow=='edit.php' &&
        isset($_GET['post_type']) && $_GET['post_type']=='portifolio' && // verifica tipo de post 'portifolio'
        isset($_GET['orderby'])  && $_GET['orderby'] !='None')  {
        $query->query_vars['orderby'] = 'meta_value';
        $query->query_vars['meta_key'] = $_GET['orderby'];
    }
}
