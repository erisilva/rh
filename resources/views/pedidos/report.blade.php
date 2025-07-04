<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">
            @page {
                margin: 0cm 0cm;
            }

            body {
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
            }

            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
                font-family: Helvetica, Arial, sans-serif;
            }

            /** Define the footer rules **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            footer .page-number:after { content: counter(page); }

            .bordered td {
                border-color: #959594;
                border-style: solid;
                border-width: 1px;
            }

            table {
                border-collapse: collapse;
            }
    </style>
</head>
    <body>
        <header>
            Pedidos
        </header>

        <footer>
          <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>
        </footer>

        <main>
            @foreach($dataset as $row)
            <table  class="bordered" width="100%">
              <tbody>


                <tr>
                    <td colspan="12">
                        <label for="nome"><strong>Nome</strong></label>
                        <div id="nome">{{ $row->nome }}</div>
                    </td>

                </tr>

                <tr>
                    <td colspan="6">
                        <label for="cargo"><strong>Cargo</strong></label>
                        <div id="cargo">{{ $row->cargo }}</div>
                    </td>

                    <td colspan="6">
                        <label for="cargo"><strong>Cargo</strong></label>
                        <div id="cargo">{{ $row->Setor}}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <label for="motivo"><strong>Motivo</strong></label>
                        <div id="motivo">{{ $row->motivo->descricao }}</div>
                    </td>
                    <td colspan="6">
                        <label for="situacao"><strong>Situação</strong></label>
                        <div id="situacao">{{ $row->situacao->descricao }}</div>
                    </td>

                </tr>

                <tr>
                    <td colspan="12">
                        <label for="justificativa"><strong>Notas</strong></label>
                        <div id="justificativa">{{ $row->nota }}</div>
                    </td>

                </tr>

                <tr>
                    <td colspan="12">
                        <label for="data_cadastro"><strong>Quando</strong></label>
                        <div id="data_cadastro">{{ $row->created_at->format('d/m/Y H:i') }}</div>
                    </td>

                </tr>



              </tbody>
            </table>
            <br>
            @endforeach
        </main>
    </body>
</html>
