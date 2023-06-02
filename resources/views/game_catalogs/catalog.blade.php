<style>

.gal-container {
  padding: 12px;
}

.gal-item {
  overflow: hidden;
  padding: 3px;
}

.gal-item .box {
  height: 350px;
  overflow: hidden;
}

.box img {
  height: 110%;
  width: 110%;
  top: -10%;
  object-fit: cover;
  -o-object-fit: cover;
  -webkit-transition: all 0.5s ease-in-out 0s;
  -moz-transition: all 0.5s ease-in-out 0s;
  transition: all 0.5s ease-in-out 0s;
}

.box:hover img{
  transform: scale(1.1);
  -webkit-transition: all 0.5s ease-in-out 0s;
  -moz-transition: all 0.5s ease-in-out 0s;
  transition: all 0.5s ease-in-out 0s;
}

.gal-item a:focus {
  outline: none;
}

.gal-item a{
  cursor: pointer;
}

.gal-item a::after {
  content: "\f00e";
  font-family: "FontAwesome";
  opacity: 0;
  background-color: rgba(0, 0, 0, 0.75);
  position: absolute;
  right: 3px;
  left: 3px;
  top: 3px;
  bottom: 3px;
  text-align: center;
  line-height: 350px;
  font-size: 30px;
  color: #fff;
  -webkit-transition: all 0.5s ease-in-out 0s;
  -moz-transition: all 0.5s ease-in-out 0s;
  transition: all 0.5s ease-in-out 0s;
}

.gal-item a:hover:after {
  opacity: 1;
}

.modal-open .gal-container .modal {
  background-color: rgba(0,0,0,0.4);
}

.modal-open .gal-item .modal-body {
  padding: 0px;
}

.modal-open .gal-item button.close {
  position: absolute;
  width: 25px;
  height: 25px;
  background-color: #000;
  opacity: 1;
  color: #fff;
  z-index: 999;
  right: -12px;
  top: -12px;
  border-radius: 50%;
  font-size: 15px;
  border: 2px solid #fff;
  line-height: 25px;
  -webkit-box-shadow: 0 0 1px 1px rgba(0,0,0,0.35);
  box-shadow: 0 0 1px 1px rgba(0,0,0,0.35);
}

.modal-open .gal-item button.close:focus {
  outline: none;
}

.modal-open .gal-item button.close span {
  position: relative;
  top: -3px;
  font-weight: lighter;
  text-shadow: none;
}

.gal-container {
  width: 80%;
}


@media (min-width: 768px) {
  .gal-container .modal-dialog {
    width: 55%;
    margin: 50 auto;
  }
}

@media (max-width: 768px) {
  .gal-container .modal-content {
    height: 250px;
  }
}


/* Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}


.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%;
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.9); 
}

.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

.modal-content, #caption { 
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
    </style>

<section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
                        <div class="box">                            
                            <a title="playa" class="link-gallery">
                                <img class="img-gallery modal-img"  src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                        <div class="box">                            
                            <a title="flores" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1515362778563-6a8d0e44bc0b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80">
                            </a>
                        </div>
                    </div>
                <!--</div>-->
                <!--<div class="row">-->
                    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                        <div class="box">                            
                            <a  title="cascada" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1444201983204-c43cbd584d93?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                        <div class="box">                                                        
                            <a title="rocas" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1549294413-26f195200c16?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1400&q=80">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                        <div class="box">                            
                            <a title="rocas" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1531003300514-1976481c521e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjUzMjV9&auto=format&fit=crop&w=1500&q=80">
                            </a>
                        </div>
                    </div>
                <!--</div>
                <div class="row">-->
                    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
                        <div class="box">
                            <a title="cascada" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1488805990569-3c9e1d76d51c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
                        <div class="box">                            
                            <a title="cancha en el bosque" class="link-gallery">
                                <img class="img-gallery" src="https://images.unsplash.com/photo-1560200353-ce0a76b1d438?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1567&q=80">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>