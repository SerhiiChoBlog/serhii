RUNNER_DEV := podman-compose -f compose.yml -f compose.dev.yml
RUNNER_PROD := podman-compose -f compose.yml -f compose.prod.yml

# ----------------- up -----------------
.PHONY := upp
upp:
	$(RUNNER_PROD) up

.PHONY := upd
upd:
	$(RUNNER_DEV) up

# ---------------- down ----------------
.PHONY := downp
downp:
	$(RUNNER_PROD) down

.PHONY := downd
downd:
	$(RUNNER_DEV) down

# ---------------- stop ----------------
.PHONY := stopp
stopp:
	$(RUNNER_PROD) stop

.PHONY := stopd
stopd:
	$(RUNNER_DEV) stop

# ---------------- build ----------------
.PHONY := buildp
buildp:
	$(RUNNER_PROD) build

.PHONY := buildd
buildd:
	$(RUNNER_DEV) build

# -------------- exec php --------------
.PHONY := execphpp
execphpp:
	$(RUNNER_PROD) exec php sh

.PHONY := execphpd
execphpd:
	$(RUNNER_DEV) exec php sh

# ------------- exec nginx -------------
.PHONY := execnginxp
execnginxp:
	$(RUNNER_PROD) exec nginx sh

.PHONY := execnginxd
execnginxd:
	$(RUNNER_DEV) exec nginx sh

# -------------- exec db ---------------
.PHONY := execdbp
execdbp:
	$(RUNNER_PROD) exec db sh

.PHONY := execdbd
execdbd:
	$(RUNNER_DEV) exec db sh

.DEFAULT_GOAL := execd
