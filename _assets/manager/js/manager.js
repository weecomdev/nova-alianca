var gerenciador_url;
var map;
var marker;
function load_items() {
    $(".various").fancybox({
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        width       : '70%',
        height      : '70%',
        autoSize    : false,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
    });
    $('.number').numeric();
    $('.phone').mask("(99) 9999-9999");
    $('.zip_code').mask("99999-999");
    $('.date').mask("99/99/9999");
    $('.time').mask("99:99");
    $('.uf').mask("aa");
}

$(document).ready(function () {
    load_items();

    $('.filter-title').on('click', displayFormFilter);
    $('.checkbox-select-all').on('click', setCheckedList);
    $('.checkbox-list-item').on('click', setCheckedSelectAll);

    $('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });

    $(".fancybox").fancybox();

    $( "ul.sortable" ).sortable({ placeholder: "ui-state-highlight" }).on('sortupdate', function() {
        var items = [];

        $("ul.sortable .ui-state-default").each(function(i){
            var order = $("ul.sortable .ui-state-default").length - i;
            obj = {"item_id": $(this).data('id'), "order": order};
            items.push(obj);
        });

        reorder(items);
    });

     $('.ui-state-default').on('dblclick', function(e){
        var href = $('.btn-success', this).attr('href');
        if(href)
        window.location = href;
    });

    $(window).bind('keydown', function(event) {
        if (event.ctrlKey || event.metaKey) {
            switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                event.preventDefault();
                 $( ".form-horizontal" ).submit();
                break;
            }
        }
    });

    $('#selecctall').click(function(event) {  
        if(this.checked) {
            $('.checkbox1').each(function() {
                this.checked = true;                
            });
        }else{
            $('.checkbox1').each(function() { 
                this.checked = false;                       
            });         
        }

        checkSelected();
    });

     checkSelected();
    $('.checkbox1').on('click', checkSelected);
    $('.remove-all').on('click', removeSelected);


    $( ".table-sortable" ).sortable({ 
        cursor: "move", 
        placeholder: "ui-state-highlight", 
        helper: function(event, ui){ 
            ui.children().each(function() { 
                $(this).width($(this).width()); 
            }); 
            return ui; 
        }, 
        activate: function( event, ui ) { 
            $('.ui-state-highlight').css({ "height": $(ui.item).height()+"px" }); 
        }

    }).on('sortupdate', function() {

        var items = [];

        $(".table-sortable tr.ui-state-default").each(function(i){
            var order = $(".table-sortable tr.ui-state-default").length - i;
            obj = {"item_id": $(this).data('id'), "order": order};
            items.push(obj);
        });

        reorder(items);
    });

    $( ".sortable, .table-sortable" ).disableSelection();

    if( $('#map_div').length > 0 ){
        if($('#longitude').val() !== '' && $('#latitude').val() !== ''){
            show_map({lati: $('#latitude').val(), longi: $('#longitude').val()}, true);
        }
    }

    $('.medias li').on('click', function(){
        var item_id = $(this).data('img-id');
        var value;
        if($(this).hasClass('added')){ value = 0; }
        else { value = 1; }

        save($(this), item_id, value);
    });
});

var reorder = function(items){
    var controller = (window.location.host == 'localhost' || window.location.host == 'c.deen.com.br') ? window.location.pathname.split('/')[3] : window.location.pathname.split('/')[2];
    if(items){
        console.log(items);
        $.ajax({
            url: gerenciador_url + controller + '/reorder' + ($('#rel_id') != null ? '/' + $('#rel_id').val() : ''),
            type: "POST",
            data: {data: items},
            success: function(data){
                if (data == 1) console.log("Sucesso!!");
                else location.reload();
            }
        });
    }
};

function displayFormFilter(){
    var element = $(this).parent().find('fieldset');
    if (element.hasClass("active")) {
        $(this).find('h3 i').removeClass('glyphicon-chevron-down');
        $(this).find('h3 i').addClass('glyphicon-chevron-right');
        element.removeClass('active');
        element.fadeOut(500);
    } else {
        $(this).find('h3 i').removeClass('glyphicon-chevron-right');
        $(this).find('h3 i').addClass('glyphicon-chevron-down');
        element.addClass('active');
        element.fadeIn(500);
    }
}

function setCheckedList(){
    $('.checkbox-list-item').attr('checked', $(this).is(":checked"));
}

function setCheckedSelectAll(){
    if(!$(this).is(":checked")) $('.checkbox-select-all').attr('checked', false);
    else
        if($('.checkbox-list-item:checked').length === $('.checkbox-list-item').length) $('.checkbox-select-all').attr('checked', true);
}

Object.keyAt = function(obj, index) {
    var i = 0;
    for (var key in obj) {
        if ((index || 0) === i++) return key;
    }
};

function google_map(address){    
    geocoder = new google.maps.Geocoder();

    geocoder.geocode( { 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results[0].geometry.location);
            show_map({lati: results[0].geometry.location[Object.keyAt(results[0].geometry.location, 0)], longi: results[0].geometry.location[Object.keyAt(results[0].geometry.location, 1)]}, false);

        } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
            map = null;
            $('#map_div').html('O endereço preenchido não foi encontrado.');
        }
    });
}

function show_map(coords, useMarker){
    console.log(coords);
    var latlng = new google.maps.LatLng(coords.lati, coords.longi);
    var options = {
        zoom: 12, 
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP, // This value can be set to define the map type ROADMAP/SATELLITE/HYBRID/TERRAIN
        navigationControl: true,
        mapTypeControl: true,
        scrollwheel: true,
        disableDoubleClickZoom: true
    };

    if (!map) map = new google.maps.Map(document.getElementById('map_div'), options);
    else map.setCenter(latlng);

    if(useMarker){
        marker = new google.maps.Marker({
            position: latlng, 
            map: map
        });
    }

    google.maps.event.addListener(map, 'click', function(event) {
        if(marker){
            marker.setPosition(event.latLng);
        } else {
            marker = new google.maps.Marker({
                position: event.latLng, 
                map: map
            });
        }
        console.log(event.latLng);
        var lat = event.latLng[Object.keyAt(event.latLng, 0)];
        var lng = event.latLng[Object.keyAt(event.latLng, 1)];

        console.log('esse', lat, lng);

        $('#latitude').val(lat);
        $('#longitude').val(lng);
    });

    $('#map_div').addClass("success");
}

var checkSelected = function () {
    var selected = false;
    $('.ui-state-default').each(function(){

        if($('.checkbox1', this).is(':checked')){
            selected = true;
            return;
        }

    });

    (selected) ? $('.remove-all').stop().fadeIn(200) :  $('.remove-all').stop().fadeOut(200);
};

var removeSelected = function (e) {
    e.preventDefault();

    $('.preloader').fadeIn(200);

    var selecteds = [];
    $('.ui-state-default').each(function(){
        
        if($('.checkbox1', this).is(':checked')){
            var id = $(this).data('id');
            deleteRequest(id);
            // selecteds.push(id);
        }

    });    
};

var deleteRequest = function(id){
    var controller = (window.location.host == 'localhost' || window.location.host == 'c.deen.com.br') ? window.location.pathname.split('/')[3] : window.location.pathname.split('/')[2];

    $.ajax({
        url: gerenciador_url + controller + '/delete/' + id,
        type: "POST",
        success: function(response){
            console.log(response);
            $('.ui-state-default').each(function(){
                if($('.checkbox1', this).is(':checked')){
                    location.reload();
                }
            });
        },

        error: function (err) {
            
        }
    });
}

var save = function(item, item_id, value){
    console.log(window.location.href + '/onBlackList/' + item_id + '/' + value)
    $.ajax({
        url: window.location.href + '/onBlackList/' + item_id + '/' + value,
        success: function(data){

            if(value === 1 ) item.addClass('added');
            else item.removeClass('added');

            console.log("success");
        } 
    });
};

var medias = {
    getIds: function (){
        var array = [];
        $('li', '.medias').each(function(i){
            array.push($(this).data('id'));
        });

        return array.sort().reverse();
    },

    getHighestId: function (){
        var array = [];
        $('li', '.medias').each(function(i){
            array.push($(this).data('id'));
        });

        return array.sort().reverse()[0];
    },

    getLowerId: function (){
        var array = [];
        $('li', '.medias').each(function(i){
            array.push($(this).data('id'));
        });

        return array.sort()[0];
    },

    getElement: function(id){
        if(id){
           return $('li', '.medias').filter(function(){ return $(this).data('id') == id});
        }
    }
};


// var onGetMedia = function(){
//     var instagram_id = medias.getHighestId();
//     var min_id = medias.getElement(medias.getHighestId()).data('img-id');

//     $.ajax({
//         url: window.location.href + '/getMedias/' + min_id + '/' + instagram_id,
//         success: function(data){
//             if(data){
//                 try{
//                     var json = JSON.parse(data);
//                 }
//                 catch(e){}

//                 if(json) parseAndPrepend(json);
//             }
//         },
//         error: function(e){
//             console.log(e.message);
//         }
//     });
// };

var parseAndPrepend = function(json){
    for( var i = 0; i < json.length; i++){
        $('.medias').prepend('<li data-img-id="' + json[i].image_id + '" class="image" data-id="' + json[i].instagram_id + '" ><img src="' + json[i].img + '"></li>');
        $('.medias li').on('click', function(){
            var item_id = $(this).data('img-id');
            var value;
            if($(this).hasClass('added')){ value = 0; }
            else { value = 1; }

            save($(this), item_id, value);
        });
    }
}