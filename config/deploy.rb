# config valid only for current version of Capistrano
lock '3.6.1'

set :application, 'drawitbook'
set :repo_url, 'ssh://hg@bitbucket.org/MishaRatnikov/drawitbook'

# Default value for :scm is :git
set :scm, :hg

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push(
	'www/.env',
	'www/config/logging.php',
)

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push(
    'www/public/arts',
    'www/public/thumbnails',
    'www/storage/logs',
)

# Default value for keep_releases is 5
set :keep_releases, 2

# Deployment process
# after "deploy:update", "deploy:cleanup"
#after "deploy", "deploy:sort_files_and_directories"


namespace :deploy do
    desc 'after_deploy'
	  task :after_deploy do
		on roles(:all) do
             execute "cd #{fetch(:release_path)}/www; composer install --no-dev && npm i && gulp build --env production"
             execute "cd #{fetch(:release_path)}/www; php artisan cache:clear && php artisan route:cache && php artisan config:cache"
             execute "cd #{fetch(:release_path)}/www; php artisan optimize && composer dumpautoload -o"
             execute "cd #{fetch(:release_path)}/www; rm -rf node_modules"
		end
	end
end
after "deploy:symlink:shared", "deploy:after_deploy"


server '23.105.246.162', user: 'deployer', roles: %w{app}