echo "Testing Taskmaster with config.yaml as arg1\n"
php taskmaster.php config.yaml
echo "\x1b[33m"
cat -v tasklog.txt
echo "\n\x1b[0mTest Concluded\n"