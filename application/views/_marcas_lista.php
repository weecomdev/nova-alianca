<div class="header">
    <h1><?php echo $brand->name; ?></h1>
    <h2>
    <a href="#!/marcas">
        <div class="close_top">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
        <div class="close_bottom">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
    </a>
    </h2>
</div>
<?php if(!empty($products)){ ?>
<div>
<ul>
<?php foreach ($products as $k => $value): ?>
    <?php if($k > 0 && $k%3 == 0){ ?>
    </ul><ul>
    <?php } ?>
    <?php 
    $category = $this->ProductCategory->get($value->product_category_id);
    ?>
    <li class="p_item active" data-brands="<?php echo $category->alias; ?>">
        <a href="<?php echo site_url('produtos/'.$category->alias.'/'.$value->alias);?>">
            <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$value->img_thumb); ?>" alt="" />
            <div class="text">
                <h1><?php echo $value->name; ?></h1>
                <h2><?php echo $value->type; ?></h2>
                <?php if(!empty($value->options)){ ?>
                <?php $items = explode(',',$value->options); ?>
                <div class="options">
                    <?php foreach ($items as $key => $v): ?>
                    <div class="types"><?php echo $v; ?></div>
                    <?php endforeach ?>
                </div>
                <?php } ?>
            </div>
        </a>
    </li>
<?php endforeach ?>
</ul> 
<div style="clear: both;"></div> 
</div>
<?php }else{ ?>
    <div class="nada"><?php echo $this->lang->line('nenhum_produto'); ?></div>
<?php } ?>
<script>
    $(".filter_sel").on("change", function() {
        var value = $(this).val();
        if(value == 0){
            $('.p_item').addClass('active');
        }else{
            $('.p_item').each(function(){
                var brands = $(this).data('brands').split(' ');
                if(brands.indexOf(value) != -1){
                    $(this).addClass('active');
                }else{
                    $(this).removeClass('active');
                }
            });
        }
    });
</script>