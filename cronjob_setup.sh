#!/bin/sh
cd $HOME
apt update && apt upgrade
apt install vim php -y
export VISUAL=vim
export EDITOR=vim
echo '#!/bin/sh' > autoloader
clear
printf "Where directory of script ?\ninput without slash (/) in last\n"
read -p 'Folder Directory: ' directory
if [ -d "$directory" ]; then
echo "cd $directory" >> autoloader
else
echo "Directory $directory doesn't exists"
exit
fi
clear
ls $directory
printf "\nWhere is your script filename ?\n"
read -p 'filename: ' filename
if [ -f "$directory/$filename" ]; then
echo "php -f $filename" >> autoloader
else
echo "file $filename doesn't exists"
exit
fi
chmod 777 autoloader
clear
cat autoloader
echo "How many minutes will cronjob run ?"
read -p 'minutes : ' minutes
if [ $minutes -eq $minutes 2>/dev/null ]; then
echo "*/$minutes * * * * sh $HOME/autoloader" > cron
else
echo "Input Number Only"
exit
fi
user=$(whoami)
crontab -c $user cron
crontab -r
crontab cron
clear && crontab -l && cat autoloader
crond stop && crond start
printf "\nCronjob setup complete. Your script will execute every $minutes minutes\n"