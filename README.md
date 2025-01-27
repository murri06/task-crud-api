# Task CRUD API #

### made by Ruslan Liakhovets ###

## Deployment ##

for local deployment, you need to install Docker,
clone repo, unzip it into a folder, use terminal to start sail with command
<br>`./vendor/bin/sail up`

After it was deployed, you can use command <br>
`./vendor/bin/sail artisan migrate --seed`<br>
to create and seed the database.

## Testing ## 

There are two pre-created users that you can use to test it out,
and below listed the credentials for them:

### First User ###

<br>email: `test@example.com`
<br>and password: `secret`

### Second User ###

<br>email: `johndoe@example.com`
<br>and password: `superSecret`

<b>Each user has six faked tasks to work with so you can test its functionality</b>
While your project is running, you can use [API documentation](http://localhost/docs)
so it will be easier to check everything ;)
