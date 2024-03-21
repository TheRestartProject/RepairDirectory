FROM node:20

RUN npm install -g cross-env@5.0.1

COPY docker-entrypoint.sh /docker-entrypoint.sh

WORKDIR /app

CMD ["node", "--version"]
