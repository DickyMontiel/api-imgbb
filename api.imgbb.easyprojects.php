<?php
    /* 
        ------------------------------------------------------------------------------------
        -------                                                                      -------
        -------                             By DickyM                                -------
        -------                                                                      -------
        ------------------------------------------------------------------------------------

        Se necesita que te crees una cuenta y generes una llave para hacer la petición aqui:
        https://api.imgbb.com/ 

        Coloca la llave que te dio la pagina en la variable $llave dentro de la funcion upload

        Contacto:
        Facebook: Frederick Eduardo Montiel Tortola
        Correo: fmontiel@easyprojects.tech

        Usa este codigo en el archivo donde lo pondras:

            require("Ruta/api.imgbb.easyprojects.php");
            $apiImgBB = new ApiImgBB;

        Verifica si es una imagen con:

            $apiImgBB->isImage($ArchivoQueSubio); ///Devuelve un booleano True o False

        Para subir la imagen a ImgBB usa:

            $apiImgBB->upload(); //Sube la imagen

        No tienes que integrar un parametro en la funcion de Cargar Imagen ya que se guarda en una variable al 
        verificar la imagen.

        Para obtener la url de la imagen debes usar la siguiente funcion que te devolverá una variable
        de tipo texto en la que se encuentra la url:

        $datoObtenido = $apiImgBB->getUrl(); //Devuelve la url

        Ahora usa la url en la variable que creaste de $datoObtenido
    */

    class ApiImgBB{
        private $json;

        private $archivo;

        public function onlyUrl($archivo){
            if($this->isImg($archivo)){
                $this->upload();
                
                return $this->getUrl();
            }else{
                return false;
            }
        }

        public function isImg($archivo){
            if(isset($archivo) or strpos($archivo['imagen']['type'], "jpg") or strpos($archivo['imagen']['type'], "jpeg") or strpos($archivo['imagen']['type'], "png")){
                $this->archivo = $archivo;
                return true;
            }else{
                return false;
            }
        }

        public function upload(){
            if(isset($this->archivo)){
                $host = "Apis"; 
                $llave = "6a33a65820643f57a4a0a9c814817ca0";

                $bin = file_get_contents($this->archivo["tmp_name"]);
                $base64 = base64_encode($bin);

                $post = "key=".$llave."&name=imagen".$host."&image=".urlencode($base64);

                $ch =   curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload");
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultado = curl_exec($ch);

                $this->json = json_decode($resultado, true);
            }
        }

        public function getJson(){
            return $this->json;
        }

        public function getUrl(){
            return $this->json['data']['url'];
        }
    }