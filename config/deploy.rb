set :application, 'drawitbook'
set :repo_url, 'ssh://git@bitbucket.org/ratnikov-mikhail/drawitbook.com'

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push(
	'www/.env',
	'www/config/logging.php',
	'www/public/ads.txt',
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

role :app, %w{deployer@37.46.135.216}

  ask(:password, nil, echo: false)
  set :ssh_options, {
    forward_agent: false,
    auth_methods: %w(password),
	user: 'deployer',
	password: fetch(:password)
  }

namespace :tests do
  desc 'Run tests locally'
  task :run do
    run_locally do
        execute "cd www && npm run php.test"
    end
  end
end

namespace :static do
  desc 'Run the precompile static files task locally'
  task :precompile do
    run_locally do
        execute "cd www && npm i && npm run build.production"
        execute "cd www && node scripts/archiver.js"
    end
  end
end

namespace :deploy do
    task :before_symlink_shared do
    on roles(:all) do
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; composer install --no-dev"
        upload! "www/public/build.zip", "#{fetch(:release_path)}/www/public"
        execute "cd #{fetch(:release_path)}/www/public; unzip -o build.zip -d build"
    end
  end
end

namespace :deploy do
    task :after_symlink_shared do
    on roles(:all) do
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; php artisan cache:clear"
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; php artisan view:clear"
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; php artisan config:cache"
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; php artisan route:cache"
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; php artisan optimize"
        execute "PATH=/opt/php72/bin:$PATH && cd #{fetch(:release_path)}/www; composer dump-autoload -o"
    end
  end
end

#before "deploy:starting", "tests:run"
before "deploy:starting", "static:precompile"
before "deploy:symlink:shared", "deploy:before_symlink_shared"
after "deploy:symlink:shared", "deploy:after_symlink_shared"
