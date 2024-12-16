
# 🚀 Despliegue Manual en Azure usando Azure CLI

## 📝 Pasos del Despliegue

### 1. Login Azure

```bash
az login
```

### 2. Verificar si hay algún registro de contenedores

```bash
az acr list --output table
```

### 2.1 Crear un registro de contenedores en caso que no haya

```bash
az acr create --resource-group MovieMate-Resources --name moviemateacr --sku Basic
```

### 3. Admin al ACR

```bash
az acr update --name moviemateacr --admin-enabled true
```

### 4. Credenciales para el docker

```bash
az acr credential show --name moviemateacr --query "{username:username, password:passwords[0].value}"
```


### 5. Iniciar sesion con las credenciales

```bash
docker login moviemateacr.azurecr.io -u moviemateacr -p <PASSWORD>
```

### 6. Subir las imagenes

#### Frontend:

```bash
docker tag es-frontend:latest moviemateacr.azurecr.io/es-frontend:latest

docker push moviemateacr.azurecr.io/es-frontend:latest
```

#### Backend:

```bash
docker tag es-backend:latest moviemateacr.azurecr.io/es-backend:latest

docker push moviemateacr.azurecr.io/es-backend:latest
```

#### Base de Datos:

```bash
docker tag postgres:latest moviemateacr.azurecr.io/db-postgres:latest

docker push moviemateacr.azurecr.io/db-postgres:latest
```



### 7. Desplegar Contenedores

##### ⚠️ NOTA ⚠️
Sigue este orden para garantizar que los servicios se desplieguen y funcionen correctamente. Tendras que cambiar la password que anteriormente has generado.

---

#### 1. Base de Datos

Despliega el contenedor de la base de datos utilizando las credenciales y configuraciones necesarias.

```bash
az container create --resource-group MovieMate-Resources ^
    --name db-container ^
    --image moviemateacr.azurecr.io/db-postgres:latest ^
    --registry-login-server moviemateacr.azurecr.io ^
    --registry-username moviemateacr ^
    --registry-password K6DoiS3DKwDrdtq21nSKRK3JJWpulcEmwrqV22NoUg+ACRBMYw50 ^
    --dns-name-label moviemate-db ^
    --ports 5432 ^
    --environment-variables POSTGRES_DB="es-b3-database" POSTGRES_USER="user" POSTGRES_PASSWORD="12345" ^
    --os-type Linux ^
    --cpu 1 ^
    --memory 1.5
```

##### ⚠️ NOTA ⚠️
Después de crear el contenedor, comprueba los logs para asegurarte de que la base de datos está funcionando correctamente. Busca un mensaje que indique que la base de datos está "ready to accept connections".

```bash
az container logs --resource-group MovieMate-Resources --name db-container
```

---

#### 2. Backend

Despliega el contenedor del backend, configurando correctamente las variables de entorno para que apunten al contenedor de la base de datos.

```bash
az container create --resource-group MovieMate-Resources ^
    --name backend-container ^
    --image moviemateacr.azurecr.io/es-backend:latest ^
    --registry-login-server moviemateacr.azurecr.io ^
    --registry-username moviemateacr ^
    --registry-password K6DoiS3DKwDrdtq21nSKRK3JJWpulcEmwrqV22NoUg+ACRBMYw50 ^
    --dns-name-label moviemate-backend ^
    --ports 3000 ^
    --environment-variables DB_HOST="moviemate-db.westeurope.azurecontainer.io" ^
                            DB_NAME="es-b3-database" ^
                            DB_PASSWORD="12345" ^
                            DB_PORT="5432" ^
                            DB_USERNAME="user" ^
                            SW_HOST="0.0.0.0" ^
                            SW_PORT="3000" ^
                            MAIL_USER="moviemate@zohomail.eu" ^
                            MAIL_PASS="Movie@1234ADJLMN" ^
                            SECRET_KEY="ES-UB-B3" ^
    --os-type Linux ^
    --cpu 1 ^
    --memory 1.5
```

##### ⚠️ NOTA ⚠️
Comprueba los logs del backend para confirmar que está en ejecución y conectado a la base de datos. Deberías ver un mensaje como `Server is listening on port 3000`.

```bash
az container logs --resource-group MovieMate-Resources --name backend-container
```

---

#### 3. Frontend

Despliega el contenedor del frontend, asegurándote de configurar las variables de entorno para que apunten al backend.

```bash
az container create --resource-group MovieMate-Resources ^
    --name frontend-container ^
    --image moviemateacr.azurecr.io/es-frontend:latest ^
    --registry-login-server moviemateacr.azurecr.io ^
    --registry-username moviemateacr ^
    --registry-password K6DoiS3DKwDrdtq21nSKRK3JJWpulcEmwrqV22NoUg+ACRBMYw50 ^
    --dns-name-label moviemate-frontend ^
    --ports 8000 ^
    --environment-variables VUE_APP_API_BASE_URL="http://moviemate-backend.westeurope.azurecontainer.io:3000" ^
    --os-type Linux ^
    --cpu 1 ^
    --memory 1.5 
```

##### ⚠️ NOTA ⚠️
Verifica los logs del frontend para confirmar que está funcionando correctamente. Busca un mensaje que indique que la aplicación está corriendo, como `App running at`.

```bash
az container logs --resource-group MovieMate-Resources --name frontend-container
```

---

#### 📝 Recomendaciones

1. Asegúrate de desplegar los servicios en el orden indicado: **🗄️ Base de Datos → 💻 Backend → 🌐 Frontend**.
2. Comprueba los logs después de cada paso para verificar que los servicios están funcionando correctamente.
3. Si encuentras algún problema, revisa las configuraciones y las variables de entorno.


### 🌐 Acceso a los Servicios

Una vez que todos los servicios estén desplegados y funcionando correctamente, podrás acceder al frontend a través de la siguiente URL:

🔗 **[MovieMate](http://moviemate-frontend.westeurope.azurecontainer.io:8000)**
