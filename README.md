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


<a name="bootstrap"></a>
## Initial Bootstrap

1. Create a directory somewhere on your file system to use for saving state
for the IGWN IAM Sandbox. For example

```
mkdir ${HOME}/igwn-sandbox
```

1. Define the environment variable `IGWN_SANDBOX` to point to the directory
you just created to use for saving state:

```
export IGWN_SANDBOX="${HOME}/igwn-sandbox"
```

1. Make the `IGWN_SANDBOX` directory the current working directory:

```
cd ${IGWN_SANDBOX}
```

1. Clone


1. 


```
mysql --host=127.00.1 --user=registry_user --password=password registry
```


```
new GrouperPasswordSave().assignApplication(GrouperPassword.Application.UI).assignUsername("GrouperSystem").assignPassword("password").save();
```


