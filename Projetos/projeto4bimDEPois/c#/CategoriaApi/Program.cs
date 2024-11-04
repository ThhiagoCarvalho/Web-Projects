WebApplicationBuilder construtor = WebApplication.CreateBuilder();
// Obtém a coleção de serviços (Dependency Injection) da aplicação
IServiceCollection servicos = construtor.Services;
// Adiciona o suporte a controladores para a API (MVC sem visão/Views)
servicos.AddControllers();
// Adiciona o suporte para explorar e gerar automaticamente endpoints da API
servicos.AddEndpointsApiExplorer(); // Para a geração de endpoints de API
// Configura o servidor Kestrel para escutar na porta 8080
construtor.WebHost.ConfigureKestrel(serverOptions =>
{
serverOptions.ListenAnyIP(7070); // Altera a porta para 8080 e permite conexões de qualquer IP
});
// Constrói a aplicação web com base nas configurações definidas anteriormente
WebApplication app = construtor.Build();
// Ativa o middleware para servir arquivos estáticos a partir da pasta "wwwroot"
app.UseStaticFiles(); // Isso faz com que arquivos em wwwroot sejam servidos
// Redireciona automaticamente as requisições HTTP para HTTPS
//app.UseHttpsRedirection();
// Configura o middleware de autorização para proteger rotas que exigem autenticação
app.UseAuthorization();
// Mapeia os controladores para suas respectivas rotas, tornando a API acessível
app.MapControllers(); // Mapeia os controladores
// Exibe uma mensagem no console indicando que a API está rodando na porta 8080
Console.WriteLine("API rodando em: http://localhost:7070");
// Inicia a aplicação e começa a escutar as requisições
app.Run();