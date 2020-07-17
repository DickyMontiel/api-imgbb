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

        Integrale un nombre predefinido con:
            
            $apiImgBB->setName($nombre); //Omitelo si quieres que se suba con el mismo nombre de la imagen

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
        private $nombre;

        public function __construct(){
            $this->nombre = null;
        }

        public function isImg($archivo){
            if(isset($archivo) and (strpos($archivo['type'], "png") or strpos($archivo['type'], "jpg") or strpos($archivo['type'], "jpeg"))){
                $this->archivo = $archivo;
                return true;
            }else{
                return false;
            }
        }

        public function upload(){
            if(isset($this->archivo)){
                $llave = "6a33a65820643f57a4a0a9c814817ca0";

                if($this->nombre == null){
                    $arrayName = explode(".", $this->archivo['name']);
                    $nombre = $arrayName[0];
                }else{
                    $nombre = $this->nombre;
                }

                $bin = file_get_contents($this->archivo["tmp_name"]);
                $base64 = base64_encode($bin);

                $post = "key=".$llave."&name=".$nombre."&image=".urlencode($base64);

                $ch =   curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload");
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultado = curl_exec($ch);

                $this->json = json_decode($resultado, true);
            }
        }

        public function setName($nombre){
            $this->nombre = $nombre;
        }

        public function getJson(){
            return $this->json;
        }

        public function getUrl(){
            return $this->json['data']['url'];
        }
    }