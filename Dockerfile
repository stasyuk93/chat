#FROM node:8.9.0
#
#WORKDIR /var/www/chat
#
##COPY package*.json ./
#
#
#RUN npm install -g pm2
#
#COPY . .
#
#CMD [ "node", "server.js" ]

FROM node:8.9.0
WORKDIR /var/www/chat/
COPY package*.json ./
RUN npm install -qy
COPY . ./
RUN npm run dev

#CMD [ "npm", "start" ]
CMD [ "node", "server.js" ]

#CMD ["/bin/bash"]