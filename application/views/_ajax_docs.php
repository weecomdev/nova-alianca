<?php if (empty($docs)): ?>
  <div style="padding: 300px 0;text-align:center;text-transform:uppercase;font-family: 'futura-pt',sans-serif; font-style: normal;"> Nenhum documento encontrado.</div>
<?php else: ?>
<ul class="row">
    <?php foreach ($docs as $k => $value): ?>
        <?php if($k > 0 && $k%3 == 0){ ?>
        </ul><ul>
        <?php } ?>   
        <li>
            <a href="<?php echo site_url(AR_PATH.$value->ar_file_category_id.'/'.$value->file); ?>">
               <div class="bg"><span class="ico"></span></div>
               <span class="title">
                        <?php $date = explode('-',$value->date); ?>
                        <h1><?php echo $this->Ar_FileCategory->get($value->ar_file_category_id)->title; ?></h1>
                        <h2><?php echo $value->name; ?></h2>
                        <h3><?php echo $date[2].' de '.getMonthBR($date[1]); ?></h3>  
                </span>
            </a>
        </li> 
    <?php endforeach ?>
</ul>
<?php endif ?>
