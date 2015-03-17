v0.2.0

This project is a simple web application that allows users to create usernames, passwords, and to upload/retrieve files. To get it working, you’ll require a local MAMP stack. Facility with The Terminal is assumed, as is the installation of [this special Bash configuration](http://roy.vanegas.org/teaching/at_the_new_school/web_advanced/code/bash_environment.tar).

Note: In the directions below, *[bash ~]* denotes your terminal — it’s not something you type. The commands you type on the keyboard follow *[bash ~]*.

## Installation
### MySQL Setup

1. Launch The Terminal.
2. Start MySQL. (You will likely be prompted for your computer’s root password.)

    > [bash ~] `startmysql`

    The Terminal will respond with about two lines of content, and its cursor will hang. This isn’t a problem; it’s exactly how The Terminal should behave.
3. Close The Terminal window you just created.
4. Open a new instance of The Terminal.
5. Navigate to the *mysql* folder contained in this project’s ZIP file.

    > [bash ~] `cd PATH/TO/WEB-APP/mysql`

    Note: You don’t actually type *PATH/TO/WEB-APP* in the command above. The path to everyone’s web-app will differ.
6. From the *mysql* folder, log in to MySQL as the *root* user, prompting MySQL to ask for your password:

    > [bash ~] `mysql -u root -p`

7. Provide MySQL the contents of *setup.sql*.

    > mysql> `source setup.sql`

    Alternatively, you could have skipped this step by carrying out the following in the previous step:

    > [bash ~] `mysql -u root -p < setup.sql`

8. Log out of MySQL

    > mysql> `exit`

9. Log back in with the credentials used in `setup.sql`

    > [bash ~] `mysql -uthe_user -pthe_password`

10. List the databases to which you have access:

    > mysql> `show databases;`

    You should see *web_app* as one of the databases.

11. Exit MySQL

    > mysql> `exit;`

### Project Folder Location
1. Uncompressing the file in which this README is contained should have created a folder called *web-app*. If this isn’t the case, please rename the folder *web-app*.

2. Place *web-app* inside your *Sites* folder, which is inside your home folder.

### File and Folder Permissions
Your final task is to ensure that the files and folders inside *web-app* have *755* permissions.

1. Navigate to the *web-app* folder.

    > [bash ~] `cd ~/Sites/web-app/`

2. Give every file in *web-app* *755* permission.

    > [bash ~] `chmod 755 *`

3. Give the *uploads* folder *777* permission.

    > [bash ~] `chmod 777 uploads`

Your web application is now ready. Assuming your web server and your MySQL server are running, open a browser and point it at *localhost/~YOUR_USERNAME/web-app*, where *YOUR_USERNAME* is your Mac username.
