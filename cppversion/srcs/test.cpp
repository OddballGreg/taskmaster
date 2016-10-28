#include "../include/taskmaster.hpp"

typedef struct      s_list
{
    char            *data;
    struct s_list   *next;
}                   t_list;

t_list  *g_head;

void    add_node(char *str)
{
    t_list  *temp;
    
    temp = (t_list*)malloc(sizeof(t_list));
    temp->data = str;
    temp->next = g_head;
    g_head = temp;
}

void    print_list()
{
    t_list  *temp;
    
    temp = g_head;
    while (temp != NULL)
    {
        puts(temp->data);
		int offset = strcspn(temp->data, "=");
		char *test = new char [256];
		test = strncpy(test, temp->data, offset);
		printf("%s\n\n", test);
        temp = temp->next;
    }
    printf("\n");

}

int     main(int argc, char **argv, char **env)
{
    (void)argc;
    (void)argv;
    
    g_head = NULL;
    int len = 0;
    while (env[len] != NULL)
        len++;
    while (--len >= 0)
        add_node(env[len]);
    print_list();

}