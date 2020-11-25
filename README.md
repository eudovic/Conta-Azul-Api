# CONTA AZUL API
Esta estrutura trata a integração com a api da conta azul, fornecendo métodos para autenticação, e request aos endpoint desejados.

## INSTALAÇÃO
composer require eudovic/contaazul:dev-master

## COMO USAR
#### CRIANDO A APLICAÇÃ0
O primeiro passo é criar uma apicação no portal de desenvolvedores da conta azul através do seguinte link https://portaldevs.contaazul.com/.
Após criar a aplicação você será redirecionado a uma tela semelhante a imagem abaixo, onde terá acesso ao client_id e secret_id da sua aplicação.

![](http://www.conectes.com.br/git_imgs_docs/contaazul/telacontazul.jpg)

Note que um ponto de muita atenção na criação da sua aplicação neste portal é a URL de redirecionamento, pois sendo a autenticação feita em OAuth2, o código de acesso ao token será enviada a esta URL para que então possa fazer o requerimento do token e passar a ter acesso aos endpoints de consulta e manipulação.
No entanto, não se preocupe com toda esta troca de informações, pois esta biblioteca cuidará do processo de autenticação facilmente se vc seguir os passos abaixo.

#### USANDO A BIBLIOTECA
###### INICIANDO A AUTENTICAÇÃO
Primeiramente é preciso fazer a chamada de início do processo de autenticação. Pra isso é preciso invocar a seguinte URL.
https://api.contaazul.com/auth/authorize?redirect_uri={REDIRECT_URI}&client_id={CLIENT_ID}&scope=sales&state={STATE}

Abaixo uma descrição de cada um dos parâmetros.
- redirect_uri : Mesma URL definida na aplicação.
- client_id: Valor no honônimo parametro recebido pela aplicação.
- scope: (Customer, Product, Service, Contract ou Sale) Define o tipo de acesso que você tem a API.
- state: Valor definido pelo desenvolvedor que servirá como chave de autenticidade do request. Ex: state=DCEeFWf45A53sdfKef424 

###### INSTANCIANDO A CLASSE
No seu arquivo php indicado na URL de redirecionamento é preciso instanciar a classe.
Exemplo de implementação da bibioteca.

```php
$requireAutoload= __DIR__. '/vendor/autoload.php';
require $requireAutoload;

use ContaAzul\ContaAzul;
use ContaAzul\Helpers\Helpers;


//VARIÁVEIS NECESSÁRIAS PARA INICIALIZAÇÃ0
$client_id="SEU_CLIENT_ID";
$client_secret="SEU_SECRET_ID";
$redirect_uri="URL_DE_REDIRECIONAMENTO";// pega a url atual para negociar os pedidos da URL de redirecionamento.
$scope="sales";
$state=Helpers::generateRandomString(16);

//INSTANCIANDO A CLASSE
$apiContaazul=new ContaAzul($client_id,$client_secret,$redirect_uri,$scope,$state);


```
###### NEGOCIANDO O TOKEN
 Agora você deve fazer uma verificação do request para capturar o código enviado pela conta AZUL no parametro ***code*** . 
 ```php
if(isset($_REQUEST['code'])){
	$getToken=$apiContaazul->requestToken($_REQUEST['code']);
  }
  ```
  Ao usar o métido requestToken você terá como retorno os seguintes parâmetros:
  -  access_token
  -   refresh_token
  -   expire_in
  
Para deixar o seu processo organizado e com boa performace, considere guardar este retorno em uma session, assim você poderá verificar posteriormente o tempo restante para expiracão do token, assim como ter acesso ao refresh_token, que será usado na renovação do token 
##### RENOVANDO O TOKEN
Bem provavelmente durante o uso do API o seu token deverá expirar, tendo em vista que o seu *lifetime* é de apenas 60 min. Não se preocupe, você poderá facilmente renovar o seu token usando o método abaixo:
```php
  $getToken=$apiContaazul->refreshToken($refresh_token);
```
###### USANDO A API
Agora, em posse do token é possivel fazer as requisições usando o método abaixo.
```php
  $request=$apiContaazul->request($endpoint,$parametros,$token,$metodo);
````
- $endpoint // endpoint de consulta
- $parametros // parametros enviados ao request
- $token // token gerado
- $metodo // get-post-put-delete-postjson(para post com json como raw data)-putjson(para put com json como raw data)

