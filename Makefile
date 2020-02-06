default: help

help: ## Help Command to output info on these make commands
	@printf "\033[33m%-30s\033[0m %s\n" 'Make commands:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

clean-db: ## Wipe database and run migrations
	./laulaman db:wipe
	./laulaman migrate

fix-code-style: ## Run code style fixer
	./vendor/bin/php-cs-fixer fix -v

