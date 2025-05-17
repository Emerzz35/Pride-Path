@component('mail::message')
# Recuperação de Senha

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent

Este link de redefinição de senha expirará em 60 minutos.

Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.

Atenciosamente,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Se você estiver tendo problemas para clicar no botão "{{ $actionText }}", copie e cole a URL abaixo
no seu navegador: <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endcomponent
@endcomponent
