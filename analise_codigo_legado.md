Diagnóstico e Correções Realizadas no Código Legado

Durante a análise do arquivo usuarios_legado.php, foram identificados alguns pontos de melhoria relacionados à segurança, organização e manutenção do código.

Na função cadastrarUsuario, foi identificado que os dados recebidos do usuário, incluindo nome, e-mail e senha, eram inseridos diretamente na instrução SQL por meio de concatenação de strings. Essa abordagem permitia possíveis ataques de SQL Injection. O código foi ajustado para utilizar Prepared Statements com PDO, passando os valores como parâmetros separados da consulta SQL. Além disso, o armazenamento da senha foi corrigido utilizando password_hash(), evitando que senhas fossem salvas em texto puro no banco de dados.

Nas funções buscarUsuarios e removerUsuario, também foram encontrados comandos SQL construídos diretamente com valores recebidos por parâmetro, como filtros de busca e identificadores de usuários. Essas consultas foram alteradas para utilizar parâmetros preparados, garantindo maior segurança na comunicação com o banco de dados.

Foi identificado ainda o uso de global $conn para acessar a conexão com o banco dentro das funções. Essa abordagem dificultava a manutenção e aumentava o acoplamento do código. Para corrigir esse ponto, a lógica de acesso aos dados foi reorganizada em uma classe UsuarioRepository, recebendo a conexão através do construtor, utilizando o conceito de injeção de dependência.

Na função buscarUsuarios, foi encontrado outro problema relacionado à mistura de responsabilidades, pois além de realizar a consulta no banco, o método também era responsável por montar e exibir o HTML da página utilizando echo. Essa implementação foi alterada para que o método retornasse apenas os dados dos usuários, deixando a responsabilidade de apresentação para a camada responsável pela interface.

Durante essa mesma análise, foi identificado um risco de vulnerabilidade XSS, pois os dados retornados do banco eram exibidos diretamente no HTML sem tratamento. A correção foi aplicada utilizando htmlspecialchars(), garantindo que caracteres especiais fossem tratados corretamente antes da exibição no navegador.

Também foram revisados os tratamentos de erro. O código anterior exibia mensagens internas do banco diretamente para o usuário, podendo revelar informações da estrutura da aplicação. O tratamento foi ajustado para utilizar exceções do PDO e retornar mensagens genéricas, evitando exposição de detalhes técnicos. Na remoção de usuários, também foi corrigida a validação do retorno da operação, passando a confirmar se algum registro realmente foi excluído.

Por fim, foram adicionadas tipagens nos métodos da classe, definindo os tipos esperados dos parâmetros e retornos das funções. Essa alteração melhora a compreensão do código e reduz erros causados pelo envio de valores em formatos incorretos.

Com essas alterações, o arquivo usuarios_legado_corrigido.php mantém as funcionalidades originais, porém apresenta uma estrutura mais segura, organizada e alinhada às boas práticas de desenvolvimento.