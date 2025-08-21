.PHONY: setup build deploy clean

setup:
	@./scripts/setup.sh

build:
	@./scripts/build.sh

deploy:
	@./scripts/deploy.sh

clean:
	@cd docker && docker-compose down
	@docker system prune -f

help:
	@echo "CardPlanet WordPress 快捷命令:"
	@echo "  make setup  - 初始化开发环境"
	@echo "  make build  - 构建主题"
	@echo "  make deploy - 部署更新"
	@echo "  make clean  - 清理环境"
