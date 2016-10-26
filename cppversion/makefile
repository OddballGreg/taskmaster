NAME= taskmaster

CC= g++ -o
CFLAGS= -Wall -Werror -Wextra
HEADER= -I include

SP= ./srcs/
SRC= 	$(SP)main.cpp\
		$(SP)shellcmd1.cpp\
		$(SP)shellcmd2.cpp\
		$(SP)config.cpp\
		$(SP)utils.cpp\
		$(SP)shell.cpp\

all: $(NAME)

$(NAME):
	@clear
	@echo "\x1b[31m-----Compiling $(NAME)\x1b[0m"
	@$(CC) $(NAME) $(CFLAGS) $(SRC) $(HEADER)
	@echo "\x1b[34m-----Done Compiling $(NAME)\x1b[0m"

clean:
	@-rm $(NAME)
	@echo "\x1b[32mCompleted Clean\x1b[0m"

fclean: clean
	@echo "\x1b[32mCompleted Full Clean\x1b[0m"

re: fclean all

me:
	@echo "sallen\nghavenga\n" > author

test: testmsg clean all
	./$(NAME) config.yaml
	@echo "\n\x1b[33m"
	@cat tasklog.txt
	@echo "\x1b[0mTest Concluded\n"

testmsg:
	@echo "\x1b[35mRecompiling and initiating test with config.yaml as arguement\x1b[0m"