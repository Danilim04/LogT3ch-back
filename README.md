# API de Cotações - Logt3ch

Este repositório contém o código-fonte do backend da API de cotações desenvolvido para a Logt3ch. A API é construída com PHP e o framework Laravel, e usa Docker-Compose para configurar o ambiente de desenvolvimento. Esta API é projetada para automatizar o processo de captação de cotações de clientes para a empresa.

## Tecnologias Utilizadas

- **PHP**: Linguagem de programação server-side.
- **Laravel**: Framework PHP para desenvolvimento web que proporciona uma estrutura robusta para aplicações.
- **Docker-Compose**: Utilizado para definir e rodar ambientes de desenvolvimento multi-container.
- **MongoDB**: Banco de dados NoSQL usado para armazenar as informações submetidas pelos clientes.
- **Google Sheets API**: Integração com Google Sheets para registrar as cotações em uma planilha, permitindo um controle detalhado dos dados captados.

## Funcionalidade da API

### Captação de Cotações
- **Recepção de Dados**: A API recebe um body de request com as informações preenchidas pelo cliente através do site.
- **Confirmação por E-mail**: Após receber os dados, a API envia um e-mail de confirmação para o cliente e notifica a equipe de marketing sobre a nova cotação.
- **Armazenamento de Dados**: Os dados recebidos são armazenados de forma segura no MongoDB.
- **Registro em Google Sheets**: Além de armazenar os dados no banco de dados, a API também registra essas informações em uma planilha do Google Sheets, facilitando o acesso e análise pela equipe de marketing.

## Exemplo de Uso

**EndPoint**: `localhost/api/cotacao`

**Body de Envio**:
```json
{
  "dadosEmpresa": {
    "nome": "Daniel",
    "empresa": "LogT3ch",
    "email": "faylouti04@gmail.com",
    "telefone": "(31) 98385-7490"
  },
  "dadosSite": {
    "tipoSite": "3",
    "tipoSiteOutros": "",
    "ObjtSite": "2",
    "ObjtSiteOutros": "",
    "expectativaSite": "1",
    "expectativaSiteOutros": "",
    "funcinabilidadesAdd": "",
    "funcinabilidadesAddOutros": "",
    "mensagem": "Estamos esperando um site que seja altamente interativo."
  }
}
