# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/var/www/deployer/data/repo/drawitbook.com'
set :site_path, '/var/www/deployer/data/www/drawitbook.com'
set :branch, :'develop'
if ENV['branch']
    set :branch, ENV['branch']
end
