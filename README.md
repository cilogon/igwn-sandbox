# IGWN IAM Sandbox

## Table of Contents
[Preliminaries](#preliminaries)  
[Initial Bootstrap](#bootstrap)  

<a name="preliminaries"></a>
## Preliminaries

1. Install the [latest version of Docker Engine](https://docs.docker.com/engine/install/) 
for Linux. Note that these instructions assume you are using Docker **Engine** and
**NOT** Docker Desktop for Linux, which runs in its own virtual machine.
[Visit this link](https://docs.docker.com/engine/install/) and scroll to the **Server** section
and then click on your desired Linux Platform.

1. Browse to [CILogon](https://cilogon.org), choose your login server, and authenticate.
After authenticating you will return to the CILogon application. Click "User Attributes" and
record the value for "CILogon User Identifier" (it will be a URL that begins with `http://cilogon.org/`). 

1. Email [help@cilogon.org](mailto:help@cilogon.org) and ask for an OIDC Client ID and Client Secret
to use for your IGWN sandbox.

<a name="bootstrap"></a>
## Initial Bootstrap

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


```
mysql --host=127.00.1 --user=registry_user --password=password registry
```


```
new GrouperPasswordSave().assignApplication(GrouperPassword.Application.UI).assignUsername("GrouperSystem").assignPassword("password").save();
```


