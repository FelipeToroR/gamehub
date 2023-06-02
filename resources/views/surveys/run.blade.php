@extends('layouts.app')

@section('content')

<style>
.box-survey {
    position: absolute;
    top: 55px;
    bottom: 35px;
    left: 10px;
    right: 10px;
    background-color: white;
    border-top-color: #3c8dbc;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.box-body {
    height: 100%;
}

#slide-show{
    height: 100%;
}



input[type="radio"] {
    display: none;
}





@media (max-width: 768px) {
    .box-survey {
        top: 105px;
    }
    .slide-likert .alts {
        margin: 0;
    }
}


.slide-likert .alts .alt-item{
    
} 

/* SLIDE LIKERT */

.slide-likert {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.slide-likert .alts {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    margin: 20px;
} 


/* SLIDE TEXT*/


.slide-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

/* SLIDE QUESTION */
.slide-question {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}


.slide-question .alts {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: 20px;
    align-items: center;
} 

.slide-question .alts .alt-item {
    display: flex;
    flex-direction: row;
    /* justify-content: unset; */
    /* margin: 20px; */
    flex-wrap: wrap;
} 

.slide-question .alts .alt-item img{
    max-width: 400px;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
/* SUBMIT */


.slide-submit {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

/* GENERAL */

.zoom {

  transition: transform .2s; /* Animation */

}

.zoom:hover {
  transform: scale(0.8); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}

.title {
  margin-bottom: 20px;
  font-size: 36px;
  font-weight: 300;
  line-height: 1.4;
  color: #367fa9;
  font-weight: bold;
  text-align: center;
}

.body {
  margin-bottom: 20px;
  font-size: 14px;
  font-weight: 300;
  line-height: 1.4;
  text-align: center;
}

.btn-container {
    justify-content: center;
    display: flex;
}

@media (min-width: 768px) {
  .title {
    font-size: 30px;
  }
  .body {
    font-size: 18px;
  }
}


.btn-fit {
    width: fit-content;
}


.lds-roller {

    width: 80px;
    height: 80px;
    position: absolute;
    top: calc(50% - 40px);
    left: calc(50% - 40px);
}
.lds-roller div {
  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 40px 40px;
}
.lds-roller div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #03a9f4;
  margin: -4px 0 0 -4px;
}
.lds-roller div:nth-child(1) {
  animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
  top: 63px;
  left: 63px;
}
.lds-roller div:nth-child(2) {
  animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
  top: 68px;
  left: 56px;
}
.lds-roller div:nth-child(3) {
  animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
  top: 71px;
  left: 48px;
}
.lds-roller div:nth-child(4) {
  animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
  top: 72px;
  left: 40px;
}
.lds-roller div:nth-child(5) {
  animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
  top: 71px;
  left: 32px;
}
.lds-roller div:nth-child(6) {
  animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
  top: 68px;
  left: 24px;
}
.lds-roller div:nth-child(7) {
  animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
  top: 63px;
  left: 17px;
}
.lds-roller div:nth-child(8) {
  animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
  top: 56px;
  left: 12px;
}
@keyframes lds-roller {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


#loading-bg {
    position: absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background-color: #ffffffb8;
    pointer-events:none;
    z-index: 10000;
}

</style>
<div class="container-fluid">
    <div class="box-survey">
        <div class="box-body">
            <div id="loading-bg">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <div id="slide-show">
                
                
                
            </div>
        </div>
    </div>
</div>

<div class="schemas" style="display: none">

    <div class="slide-text">
        <div class="title">
        </div>
        <div class="body">
        </div>
        <div class="btn-container">
            <button class="btn btn-primary btn-lg btn-fit btn-next zoom" onclick="send_one()">Continuar »</button>
        </div>
    </div>

    <div class="slide-question">
        <div class="title">
            item
        </div>
        <div class="alts">
            
        </div>
        
    </div>

    <div class="slide-likert">
        <div class="title">
        </div>
        <div class="alts">
                <div class="alt-item">
                    <div class="custom-control custom-radio image-checkbox">
                        <input data-value="1" type="radio" class="custom-control-input" id="ck2a" name="ck2" onchange="send_one(this)">
                        <label class="custom-control-label" for="ck2a">
                            <img src="\assets\img\smiles\smile_1.png" alt="#" class="img-responsive zoom">
                            <p class="lead">Muy en desacuerdo</p>
                        </label>
                    </div>
                </div>
                <div class="alt-item">
                    <div class="custom-control custom-radio image-checkbox">
                        <input data-value="2" type="radio" class="custom-control-input" id="ck2b" name="ck2" onchange="send_one(this)">
                        <label class="custom-control-label" for="ck2b">
                            <img src="\assets\img\smiles\smile_2.png" alt="#" class="img-responsive zoom">
                            <p class="lead">En desacuerdo</p>
                        </label>
                    </div>
                </div>
                <div class="alt-item">
                    <div class="custom-control custom-radio image-checkbox">
                        <input data-value="3" type="radio" class="custom-control-input" id="ck2c" name="ck2" onchange="send_one(this)">
                        <label class="custom-control-label" for="ck2c">
                            <img src="\assets\img\smiles\smile_3.png" alt="#" class="img-responsive zoom">
                            <p class="lead">No lo sé</p>
                        </label>
                    </div>
                </div>
                
                <div class="alt-item">
                    <div class="custom-control custom-radio image-checkbox">
                        <input data-value="4" type="radio" class="custom-control-input" id="ck2d" name="ck2" onchange="send_one(this)">
                        <label class="custom-control-label" for="ck2d">
                            <img src="\assets\img\smiles\smile_4.png" alt="#" class="img-responsive zoom">
                            <p class="lead">De acuerdo</p>
                        </label>
                    </div>
                </div>


                <div class="alt-item">
                    <div class="custom-control custom-radio image-checkbox">
                        <input data-value="5" type="radio" class="custom-control-input" id="ck2e" name="ck2" onchange="send_one(this)">
                        <label class="custom-control-label" for="ck2e">
                            <img src="\assets\img\smiles\smile_5.png" alt="#" class="img-responsive zoom">
                            <p class="lead">Muy de acuerdo</p>
                        </label>
                    </div>
                </div>

        </div>
    </div>

  
    <div class="slide-submit">
        <div class="title">
            ¡Muchas gracias!
        </div>
        <p class="body">Si estas listo para disfrutar de la experiencia educativa, haz clic en el siguiente botón</p>
        <div class="btn-container">
            <button class="submit_button btn btn-primary btn-lg btn-fit btn-next zoom" data-action="start-game" data-value="end" data-label="end" data-title="Fin Test" onclick="send_one(this)">¡Comenzar con el juego!</button>
        </div>
    </div>
 

</div>

        
@endsection


@push('scripts')
<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>
<script>
    // TEMPORAL
    // Oculta barra de navegación para todos los demás, menos administrador
    $("body").removeClass("sidebar-mini");
    $("body").addClass("sidebar-collapse");
    $(".sidebar-toggle").hide();
</script>


<script>

    // Carga de formulario
    var input = {!! ($survey->body) !!};

    var lastLabelResponseSlide = {!! (isset($last_survey) ? '"'.$last_survey->label.'"' : 'null') !!};

    // Respuestas a enviar a servidor
    var json_data = {
        'response': {}
    };



    var currentSlide = -1;


    $(document).ready(function(){
        //$("#send").on('click', send);
        renderNextSlideByLabel(lastLabelResponseSlide);
    });


    function createResponseRequest(context){
        // Si existe contexto, 
        item = {};
        item.label = $(context).data('label');
        item.value = $(context).data('value');
        item.question = $(context).data('title');
        if(typeof $(context).data('value') !== 'undefined'){
            item.action = $(context).data('action');
        }
        return item;
    }


    /**
    * Renderiza un slide basado en el label
    */
    function renderNextSlideByLabel(label){

        if(label == null){
            return renderSlide(0);
        }

        for(var idx=0; idx<input.slides.length; idx++){
            if(label == input.slides[idx].label){
                if((idx+1) <= input.slides.length){
                    return renderSlide(idx+1);
                }else{
                    // Si la siguiente no existe, renderiza la última.
                    return renderSlide(idx);
                }
            }
        }

        return renderSlide(input.slides.length - 1);
    }

    function renderNextSlide(){
        renderSlide(currentSlide + 1);
    }

    /**
    * Renderiza un slide basado en el índice entregado
    *
    */
    function renderSlide(slideIndex, context = null){
        console.log("sidx" + slideIndex);

        // Establece indice de slide a renderizar
        currentSlide = slideIndex;

        var first = input.slides[currentSlide]; 
        var type = first.type;
        
        $("#slide-show").empty();
        var content = $(".schemas ." + type);
        var cloned = content.clone();
        $("#slide-show").append(cloned);
        
        // Carga recursos segun tipo de slide
        if(type == 'slide-text'){
            $('#slide-show .title').text(first.title);
            $('#slide-show .body').text(first.body);
        }else if(type == 'slide-likert'){
            $('#slide-show .title').text(first.title);
            $('#slide-show .slide-likert .alts .alt-item .image-checkbox input').data('label', first.label);
            $('#slide-show .slide-likert .alts .alt-item .image-checkbox input').data('title', first.title);
        }else if(type == 'slide-question'){
            $('#slide-show .title').text(first.title);
            for(var i=0; i < first.alts.length; i++){
                // Las que tienen imagenes, muestra solo imagen
                //Las que tienen texto, muestra solo texto
                if(first.alts[i].image){
                    $("#slide-show .alts").append('<div class="alt-item img-responsive"> \
                        <img data-title="'+first.title+'" data-label="' + first.label + '" data-value="' + first.alts[i].value + '" src="' + first.alts[i].image + '" class="img-responsive zoom" style="margin: 4px 0;"  onclick="send_one(this)"/>'+
                   ' </div>');
                }else if(first.alts[i].label){
                    $("#slide-show .alts").append('<div class="alt-item"> \
                        <button data-title="'+first.title+'"  data-label="' + first.label + '" data-value="' + first.alts[i].value + '" class="btn btn-block btn-lg btn-primary"  onclick="send_one(this)">' + first.alts[i].label + '</button> \
                    </div>');
                }
            }
            //$('#slide-show .slide-question .alts .alt-item button').data('label', first.label);
        }else if(type == 'slide-question'){
            // wat? -> Buena pregunta.
        }

        // Si presenta audio, reproduce
        if(first.audio){
            $.playSound(first.audio);
        }

        $("#loading-bg").fadeOut();

    }


    function send_one(context){

        //$(".submit_button").text('Enviando tu respuestas ... <Espere>');
        $("#loading-bg").fadeIn();

        if(context == null){
            // Si es slide informativa
            renderNextSlide();
            return;
        }

        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/experiment/{{$experiment_id}}/survey/{{$survey->id}}" ,
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    response: createResponseRequest(context)
                })
            })
            .then(function(data_result){
                if(data_result && data_result['result'] == 0 && data_result['url']){
                    window.location.replace(data_result['url']);
                    return;
                }else if(data_result && data_result['result'] == 0 ){
                    renderNextSlide();
                }
            });
    }

    /**
    *
    */
    function send_all(){

        $(".submit_button").text('Enviando tus respuestas ... <Espere>');
        $(".submit_button").prop('disabled', true);
        
        debugger;
        $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/experiment/{{$experiment_id}}/survey/{{$survey->id}}" ,
                data: json_data
            })
                .then(function(data_result){
        debugger;
                    
                    if(data_result && data_result['result'] == 0){
                        window.location.replace(data_result['url']);
                    }

                });
    }


    

</script>


@endpush