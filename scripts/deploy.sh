#!/bin/bash
echo "🚀 部署CardPlanet WordPress..."
./scripts/build.sh
cd docker
docker-compose restart
echo "✅ 部署完成！"
