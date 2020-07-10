<?php
    /* 
        ------------------------------------------------------------------------------------
        -------                                                                      -------
        -------                             By DickyM                                -------
        -------                                                                      -------
        ------------------------------------------------------------------------------------

        Se necesita que te crees una cuenta y generes una llave para hacer la petición aqui:
        https://api.imgbb.com/ 

        Contacto:
        Facebook: Frederick Eduardo Montiel Tortola
        Correo: fmontiel@easyprojects.tech

        Este es un ejemplo del resultado que dará:
        Para acceder a la url de la imagen, en el array donde esta lo que retorna esta api tienes que llamar al array
        donde guardaste los datos y a continuacion esto:

        {
            "data": {
                "id": "2ndCYJK",
                "url_viewer": "https://ibb.co/2ndCYJK",
                "url": "https://i.ibb.co/w04Prt6/c1f64245afb2.gif",
                "display_url": "https://i.ibb.co/98W13PY/c1f64245afb2.gif",
                "title": "c1f64245afb2",
                "time": "1552042565",
                "expiration":"0",
                "image": {
                "filename": "c1f64245afb2.gif",
                "name": "c1f64245afb2",
                "mime": "image/gif",
                "extension": "gif",
                "url": "https://i.ibb.co/w04Prt6/c1f64245afb2.gif",
                "size": 42
            },

            "thumb": {
                "filename": "c1f64245afb2.gif",
                "name": "c1f64245afb2",
                "mime": "image/gif",
                "extension": "gif",
                "url": "https://i.ibb.co/2ndCYJK/c1f64245afb2.gif",
                "size": "42"
                },
                "medium": {
                "filename": "c1f64245afb2.gif",
                "name": "c1f64245afb2",
                "mime": "image/gif",
                "extension": "gif",
                "url": "https://i.ibb.co/98W13PY/c1f64245afb2.gif",
                "size": "43"
            },

            "delete_url": "https://ibb.co/2ndCYJK/670a7e48ddcb85ac340c717a41047e5c"
        },  
            "success": true,
            "status": 200
        }
    */

    class ApiImgBB{
        private $json;

        public function __construct($archivo){
            if(isset($archivo)){
                $host = "KipuStudios"; //Escribe el nombre de tu empresa
                $llave = "8ebe673d49502b9fc3c1c2f8dee50a5b"; //Ingresa la llave que te dió imgbb

                $bin = file_get_contents($archivo["tmp_name"]);
                $base64 = base64_encode($bin);

                //Si quieres que la imagen expire, puedes usar un parametro mas: "&expire=[Segundos]"
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
    }