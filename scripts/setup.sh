#!/bin/bash
echo "🚀 初始化 CardPlanet WordPress 开发环境..."
cd docker
docker-compose up -d
echo "✅ 环境启动完成！访问: http://localhost:8080"
