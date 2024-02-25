import pwd
import grp
from flask import Flask, request, Response

app = Flask(__name__)

# Usrname and Psswd HrdCoded
AUTH_CREDENTIALS = {'test': 'abcABC123'}

def check_auth(username, password):
    """Check if a username/password combination is valid."""
    return AUTH_CREDENTIALS.get(username) == password

def authenticate():
    """Sends a 401 response that enables basic auth."""
    return Response('Authentication required', 401, {'WWW-Authenticate': 'Basic realm="Login Required"'})

@app.route('/api/users', methods=['POST'])
def g_users():
    auth = request.authorization
    if not auth or not check_auth(auth.username, auth.password):
        return authenticate()

    try:
        users_dict = {}
        for user in pwd.getpwall():
            users_dict[user.pw_uid] = user.pw_name
        return str(users_dict)
    except Exception as e:
        return 'Error: ' + str(e)

@app.route('/api/groups', methods=['POST'])
def g_groups():
    auth = request.authorization
    if not auth or not check_auth(auth.username, auth.password):
        return authenticate()
    try:
        groups_dict = {}
        for group in grp.getgrall():
            groups_dict[group.gr_gid] = group.gr_name
        return str(groups_dict)
    except Exception as e:
        return 'Error: ' + str(e)

if __name__ == '__main__':
    app.run(host='localhost', port=3000)

#Commands that let you access associated locations (groups or users)
# curl -X POST -u test:abcABC123 http://192.168.0.36:3000/api/users
# curl -X POST -u test:abcABC123 http://192.168.0.36:3000/api/groups
