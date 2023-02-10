@component('mail::message')
<h1>Nous avons bien reçu votre demande de réinitialisation du mot de passe de votre compte</h1>
<p>Vous pouvez utiliser la commande de code suivante pour récupérer votre compte : </p>
@component('mail::panel')
{{ $code }}
@endcomponent
<p style="text-align: center">
  <button style="box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    background-color: #E84C03;
    border: none;
    padding: 15px 32px;
    text-decoration: none !important;
    text-align: center;
    display: inline-block;"
    >
    <a style='color: white;text-decoration: none !important;font-size: 18px'
             href="{{ env('APP_FRONTEND_URL') }}/changer_password">
               Reset Mot de passe
    </a>
   </button>
</p>
<p>La durée autorisée pour le code est de 1h à partir de l'envoi du message</p>
@endcomponent
