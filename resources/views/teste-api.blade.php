<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste API</title>
</head>

<body>
    <button onclick="testarApi()">Testar API</button>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function testarApi(){
            axios.get('http://127.0.0.1:8000/api/clientes-completo/1')
                .then(response =>{
                    alert('Deu Certo');
                    console.log(response);
                })
                .catch(error => {
                    alert('Falhou');
                    console.log(error);
                })
        }
    </script>
</body>

</html>