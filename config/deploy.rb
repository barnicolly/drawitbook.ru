# config valid only for current version of Capistrano
lock '3.6.1'

set :application, 'drawitbook'
set :repo_url, 'ssh://git@bitbucket.org/MishaRatnikov/drawitbook.ru'

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push(
	'www/.env',
	'www/config/logging.php',
	'www/app/Providers/AppServiceProvider.php',
)

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push(
    'www/public/content',
    'www/public/sitemaps',
    'www/storage/framework/cache',
    'www/storage/logs',
)

set :keep_releases, 2

role :app, %w{deployer@62.109.31.189}

  ask(:password, nil, echo: false)
  set :ssh_options, {
    forward_agent: false,
    auth_methods: %w(password),
	user: 'deployer',
	password: fetch(:password)
  }


# Deployment process
# after "deploy:update", "deploy:cleanup"
namespace :deploy do
    desc 'default description'
	  task :before_symlink_shared do
		on roles(:all) do
		  execute "cd #{fetch(:release_path)}/www; composer install --no-dev"
		  execute "cd #{fetch(:release_path)}/www; npm i"
		  execute "cd #{fetch(:release_path)}/www; gulp build --env production"
		  execute "cd #{fetch(:release_path)}/www; rm -rf node_modules"
		end
	end
end
before "deploy:symlink:shared", "deploy:before_symlink_shared"

namespace :deploy do
    desc 'default description'
    task :after_symlink_shared do
    on roles(:all) do
        execute "cd #{fetch(:release_path)}/www; php artisan cache:clear"
        execute "cd #{fetch(:release_path)}/www; php artisan view:clear"
        execute "cd #{fetch(:release_path)}/www; php artisan config:cache"
        execute "cd #{fetch(:release_path)}/www; php artisan route:cache"
        execute "cd #{fetch(:release_path)}/www; php artisan optimize"
        execute "cd #{fetch(:release_path)}/www; composer dump-autoload -o"
    end
  end
end
after "deploy:symlink:shared", "deploy:after_symlink_shared"