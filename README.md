1. Go to your folder.
2. git clone https://github.com/f1ssur4/todo-list.git
3. cd todo-list
4. cd .env.example .env
5. OPTIONAL - change local ports for services (mysql, nginx, node)
6. docker compose up --build -d
7. go to (ON MAC OS) nano /etc/hosts
8. add: 127.0.0.1 todo-list
9. go to your browser and type: http://todo-list:{your port from .env (DEFAULT IS 8081)}
