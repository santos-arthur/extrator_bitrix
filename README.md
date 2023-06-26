# Extrator de Tarefas Bitrix24

Comandos úteis:

Migrate - Aplica as alterações do banco de dados:
```bash 
php artisan migrate
```

Work - Ativa uma instância de execução de job (Pode ser executado mais de uma vez para paralelismo):
```bash 
php artisan queue:work
```

Listar os comandos personalizados:
````bash
php artisan app --help    
````

Sequência indicada para execução da importação:
````bash
php artisan app:import-groups

php artisan app:import-users

php artisan app:import-stages

php artisan app:import-tasks

php artisan app:import-leadtimes
````


