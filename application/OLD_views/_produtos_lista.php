<div class="header color-<?php echo $category->color ?>">
    <h1 class="color-<?php echo $category->color ?>"><?php echo $category->name; ?></h1>
    <h2>
    <?php echo $this->lang->line('filtrar_por_marcas'); ?>
    <div class="selecter_filter">
        <select name="" id="" class="filter_sel">
        <option value="0"><?php echo $this->lang->line('todas'); ?></option>
        <?php foreach ($brands as $key => $value): ?>
            <option value="<?php echo $value->product_brand_id; ?>"><?php echo $value->name; ?></option>
        <?php endforeach ?>
        </select>
    </div>
    <a href="#!/">
        <div class="close_top color-<?php echo $category->color ?>">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
        <div class="close_bottom color-<?php echo $category->color ?>">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
    </a>
    </h2>
</div>
<?php if(!empty($products)){ ?>
<div>
<div class="color-<?php echo $category->color ?>">
<ul>
<?php 
    $products_total = count($products);
    $addclass = '';
 ?>
<?php foreach ($products as $k => $value): ?>
    <?php if($k > 0 && $k%3 == 0){ 
            if($products_total - $k == 2){
                $addclass = 'fifty';
            }else if($products_total - $k == 1){
                $addclass = 'unic';
            }

        ?>
    </ul><ul>
    <?php } ?>

    <?php 
    $brands = $this->Product->getMyBrands($value->product_id);
    $brands_string = '';
    if(!empty($brands)){
        foreach($brands as $b){
            $brands_string .= $b.' ';
        }
    }


    ?>
    <li class="p_item active <?php echo $addclass; ?>"  data-brands="<?php echo $brands_string; ?>">
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
                setTimeout(function(){adjust();},500);
            });
        }
    });
</script>