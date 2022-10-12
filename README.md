# IGWN IAM Sandbox

## Table of Contents
[Preliminaries](#preliminaries)  
[Initial Services Bootstrap](#bootstrap)  
[Docker Compose Tips](#composetips)  
[Inspecting Database Tables](#databasetables)  

<a name="preliminaries"></a>
## Preliminaries

1. Install the [latest version of Docker Engine](https://docs.docker.com/engine/install/) 
for Linux. Note that these instructions assume you are using Docker **Engine** and
**NOT** Docker Desktop for Linux, which runs in its own virtual machine.
[Visit this link](https://docs.docker.com/engine/install/) and scroll to the **Server** section
and then click on your desired Linux Platform.

1. Browse to [CILogon](https://cilogon.org), choose your login server, and authenticate.
After authenticating you will return to the CILogon application. Click "User Attributes" and
record the value for "CILogon User Identifier" (it will be a URL that begins with `http://cilogon.org/`, an
example is `http://cilogon.org/serverT/users/2604273`). 

1. Email [help@cilogon.org](mailto:help@cilogon.org) and ask for an OIDC Client ID and Client Secret
to use for your IGWN sandbox.

1. Obtain SMTP configuration details, including any necessary credentials, for a SMTP server that your
sandbox can use for outoing email messages. You may want to use a Gmail account with 
an [App Password](https://support.google.com/mail/answer/185833?hl=en).

<a name="bootstrap"></a>
## Initial Services Bootstrap

1. Clone this repository to your local filesystem:

    ```
    git clone https://github.com/cilogon/igwn-sandbox.git
    ```

1. Make the cloned repository the current working directory:

    ```
    cd igwn-sandbox
    ```

1. Define the environment variable `IGWN_SANDBOX` to point to the 
cloned directory:

    ```
    export IGWN_SANDBOX=$(pwd)
    ```

1. Edit the file `etc/apache2/conf-enabled/mod-auth-openidc.conf` and replace `YOUR_CLIENT_ID` with your OIDC Client
   ID and replace `YOUR_CLIENT_SECRET` with your OIDC Client Secret. Also replace `YOUR_RANDOM_STRING` with some 20
   character random string of your choice.

1. Edit the file `docker-compose.yml` and replace `YOUR_GIVEN_NAME` with your given name, `YOUR_FAMILY_NAME` with
   your family name, and `YOUR_CILOGON_USERNAME` with your CILogon User Identifier.

1. Edit the file `srv/comanage-registry/local/Config/email.php` with the details of your SMTP configuration.

1. Start the services using Docker Compose (make sure `${IGWN_SANDBOX}` is your current directory):
    ```
    docker compose up -d
    ```

1. Monitor the Registry logs by doing

    ```
    docker compose logs -f registry
    ```

    until you see `[core:notice] [pid 1] AH00094: Command line: 'apache2 -D FOREGROUND'`

1. Browse to

    ```
    https://localhost/registry/
    ```

    and click through the warning about the self-signed X.509 certificate.

1. Click `LOGIN` and then authenticate using CILogon and the login server you used when you recorded
   your CILogon User Identifier.

1. Break into the Grouper UI container as the user tomcat by running

    ```
    docker exec -u tomcat -it igwn-sandbox-grouper-ui-1 /bin/bash
    ```

1. Start the Grouper GSH binary:

    ```
    ./bin/gsh.sh
    ```

1. Execute the following GSH command:

    ```
    new GrouperPasswordSave().assignApplication(GrouperPassword.Application.UI).assignUsername("GrouperSystem").assignPassword("password").save();
    ```

1. Browse to 

    ```
    https://localhost/grouper/
    ```

    and when prompted enter the login `GrouperSystem` and password `password` and verify that you can
    login to the Grouper UI as the GrouperSystem user.

1. Exit GSH by entering `Ctrl+d` and then exit the container by entering `exit`.

1. Now that the Grouper UI has run and initialized the Grouper database, start the Grouper web services (WS) by running

    ```
    docker compose --profile grouper-ws up -d
    ```

1. Monitor the Grouper WS logs by doing

    ```
    docker compose logs -f grouper-ws
    ```

    until you see a line like `Server startup in 10673 ms`

1. Break into the Grouper WS container as the user tomcat by running

    ```
    docker exec -u tomcat -it igwn-sandbox-grouper-ws-1 /bin/bash
    ```

1. Start the Grouper GSH binary:

    ```
    ./bin/gsh.sh
    ```

1. Execute the following GSH command:

    ```
    new GrouperPasswordSave().assignApplication(GrouperPassword.Application.WS).assignUsername("GrouperSystem").assignPassword("password").save();
    ```

1. Exit GSH by entering `Ctrl+d` and then exit the container by entering `exit`.

1. Test the Grouper WS using the `curl` and `jq` commands:

    ```
    curl \
        -k \
        -u GrouperSystem:password \
        'https://localhost/grouper-ws/servicesRest/json/v2_5_000/groups/etc%3Asysadmingroup/members' \
        | jq
    ```

    The output should look something like this:

    ```
    {
      "WsGetMembersLiteResult": {
        "resultMetadata": {
          "success": "T",
          "resultCode": "SUCCESS",
          "resultMessage": "Success for: clientVersion: 2.5.0, wsGroupLookups: Array size: 1: [0]: WsGroupLookup[pitGroups=[],groupName=etc:sysadmingroup]\n\n, memberFilter: All, includeSubjectDetail: false, actAsSubject: null, fieldName: null, subjectAttributeNames: null\n, paramNames: \n, params: null\n, sourceIds: null\n, pointInTimeFrom: null, pointInTimeTo: null, pageSize: null, pageNumber: null, sortString: null, ascending: null"
        },
        "wsGroup": {
          "extension": "sysadmingroup",
          "displayName": "etc:sysadmingroup",
          "description": "system administrators with all privileges",
          "uuid": "0ee05235ee2643ee8f3049b7ff2ee096",
          "enabled": "T",
          "displayExtension": "sysadmingroup",
          "name": "etc:sysadmingroup",
          "typeOfGroup": "group",
          "idIndex": "10000"
        },
        "responseMetadata": {
          "serverVersion": "2.5.60",
          "millis": "39"
        }
      }
    }
    ```

1. Start the Grouper daemon by running

    ```
    docker compose --profile grouper-ws --profile grouper-daemon up -d
    ```

1. Fix the permission of the `srv/comanage-registry/local/Plugin` directory:

    ```
    sudo chown $USER srv/comanage-registry/local/Plugin
    ```

1. Clone the MyligosyncJob as a submodule:

    ```
    git submodule add https://github.com/cilogon/MyligosyncJob.git srv/comanage-registry/local/Plugin/MyligosyncJob
    ```

1. Edit the COmanage Registry database configuration file `srv/comanage-registry/local/Config/database.php` and replace
`YOUR_LOGIN` and `YOUR_PASSWORD` with the database credentials given to you by the MyLIGO team.

1. Log back into COmanage Registry as the platform administrator and create the LIGO CO by browsing to
`Platform > COs > Add CO`. Name the new CO `LIGO` with Description `LIGO`.

1. Break into the COmanage Registry container and run the MyLIGO sync job to pull data from MyLIGO into COmanange Registry:
    ```
    docker exec -it igwn-sandbox-registry-1 /bin/bash
    cd /srv/comanage-registry/app
    find tmp/cache -type f -delete
    ./Console/cake job MyligosyncJob.Myligosync -c 2 -s -v
    find tmp/cache -type f -delete
    ```

<a name="composetips"></a>
## Docker Compose Tips

1. To bring all services up in the background:

    ```
    docker compose --profile grouper-ws --profile grouper-daemon up -d
    ```

1. To bring the services down:

    ```
    docker compose --profile grouper-ws --profile grouper-daemon down
    ```

1. To see all log files from all services:

    ```
    docker compose logs
    ```

1. To follow all log files from all services:

    ```
    docker compose logs -f
    ```

1. To see the log files for just Registry (service name `registry`):

    ```
    docker compose logs registry
    ```

1. To follow the fog files for just Registry (service name `registry`):

    ```
    docker compose logs -f registry
    ```

<a name="databasetables"></a>
## Inspecting Database Tables

To connect to the database so that you can inspect database tables do

```
mysql --host=127.00.1 --user=registry_user --password=password registry
```




