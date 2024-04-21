<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificação de Cotação</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">
    <table style="width: 100%; max-width: 600px; margin: auto; border-collapse: collapse;">
        <tr>
            <td style="text-align: center;">
                <img src="https://i.imgur.com/VYWqVcZ.jpg" alt="Logo" style="max-width: 100px; margin-bottom: 30px;">
            </td>
        </tr>
        <tr>
            <td style="color: #0056B3; text-align: center; padding: 20px; font-size: 24px;">
                Uma nova Cotação foi feita
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p style="margin-bottom: 5px;"><strong>Dados da cotação:</strong></p>
                <p style="margin-bottom: 10px;">Nome: {{ $dadosCotacao['infoEmpresa']['nome']}}</p>
                <p style="margin-bottom: 10px;">Nome da empresa: {{ $dadosCotacao['infoEmpresa']['empresa']}}</p>
                <p style="margin-bottom: 10px;">E-mail: {{ $dadosCotacao['infoEmpresa']['email']}}</p>
                <p style="margin-bottom: 10px;">Telefone: {{ $dadosCotacao['infoEmpresa']['telefone']}}</p>

                <p style="margin-bottom: 10px;">Tipo do site: {{ $dadosCotacao['infoSite']['tipoSite']}}</p>
                <p style="margin-bottom: 10px;">Objetivo do Site: {{ $dadosCotacao['infoSite']['ObjtSite']}}</p>
                <p style="margin-bottom: 10px;">Expectativa do Site: {{ $dadosCotacao['infoSite']['expectativaSite']}}</p>
                @if (isset($dadosCotacao['infoSite']['funcinabilidadesAdd']))
                <p style="margin-bottom: 10px;">Funcionalidades Adicionais: {{ $dadosCotacao['infoSite']['funcinabilidadesAdd'] }}</p>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                <a href="https://docs.google.com/spreadsheets/d/1ZhT48EIwFBWy28kkIqwnf4XvXyju0RFCUaQ9Hj19NWs/edit#gid=0" style="display: inline-block; padding: 10px 20px; background-color: #FD7E14; color: #ffffff; text-decoration: none; border-radius: 5px;">Link da Planilha de acesso aos dados</a>
            </td>
        </tr>
    </table>
</body>

</html>