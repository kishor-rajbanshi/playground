#!/bin/sh

set -e

# --- Colors ---
CLR_BOX='\033[32m'
CLR_DANGER='\033[31m'
CLR_RESET='\033[0m'
CLR_QUESTION='\033[34m'

# --- Terminal width ---
width=$(tput cols 2>/dev/null)
width=${width:-64}
[ "$width" -gt 80 ] && width=80
hline=$(printf '─%.0s' $(seq 1 $((width - 2))))

# --- Config ---
GIST_RAW="https://gist.githubusercontent.com/kishor-rajbanshi/8122ab798b9478c0c574ba6cca0e581b/raw"
WORKFLOW_SRC="continuous-deployment.yml"
DEPLOY_SRC="deploy.sh"
WORKFLOWS_DIR=".github/workflows"

# --- Prompt config ---
branch_question="Which branch do you want to run this workflow on?"
branch_hint="E.g. main, staging, feature/login"

# --- Draw box ---
draw_box() {
	_color="$1"
	q_len=${#branch_question}
	q_pad=$(printf '─%.0s' $(seq 1 $((width - q_len - 4))))
	h_len=${#branch_hint}
	h_space=$(printf ' %.0s' $(seq 1 $((width - h_len - 4))))
	printf "${_color}┌${CLR_RESET} ${CLR_QUESTION}%s${CLR_RESET} ${_color}%s┐${CLR_RESET}\n" "$branch_question" "$q_pad"
	printf "${_color}│${CLR_RESET} \033[2m%s%s\033[0m ${_color}│${CLR_RESET}\n" "$branch_hint" "$h_space"
	printf "${_color}└%s┘${CLR_RESET}\n" "$hline"
}

# --- Handle Ctrl+C ---
handle_cancel() {
	printf "\r\033[2K\033[1A"
	draw_box "$CLR_DANGER"
	printf "${CLR_DANGER}  Cancelled.${CLR_RESET}\n"
	exit 1
}
trap handle_cancel INT

# --- Validate branch name against Git's naming rules ---
is_valid_branch() {
	b="$1"
	[ -z "$b" ] && return 1
	[ "$b" = "@" ] && return 1
	case "$b" in
	[./-]*) return 1 ;;
	esac
	case "$b" in
	*[./-]) return 1 ;;
	*'.lock') return 1 ;;
	esac
	case "$b" in
	*' '* | *'~'* | *'^'* | *':'* | *'?'* | *'*'* | *'['* | *'\'*) return 1 ;;
	*'..'* | *'//'* | *'@{'*) return 1 ;;
	esac
	_oldifs="$IFS"
	IFS='/'
	for _seg in $b; do
		case "$_seg" in
		'.'* | *'.lock')
			IFS="$_oldifs"
			return 1
			;;
		esac
	done
	IFS="$_oldifs"
	return 0
}

# --- Prompt loop ---
while true; do
	draw_box "$CLR_BOX"
	printf "\033[2A\033[3G"
	read -r branch </dev/tty || handle_cancel
	printf "\033[2B\n"

	if [ -z "$branch" ]; then
		printf "${CLR_DANGER}  Branch name cannot be empty.${CLR_RESET}\n" >&2
		continue
	fi
	if ! is_valid_branch "$branch"; then
		printf "${CLR_DANGER}  Invalid branch name. Please enter a valid Git branch name.${CLR_RESET}\n" >&2
		continue
	fi
	break
done

trap - INT

# --- Normalize branch for filename and variable suffix ---
branch_slug=$(
	printf '%s' "$branch" |
		tr '[:upper:]' '[:lower:]' |
		tr -cs 'a-z0-9' '-' |
		sed 's/^-//;s/-$//'
)
branch_slug=${branch_slug:+-$branch_slug}

branch_key=$(printf '%s' "${branch_slug#-}" | tr '[:lower:]' '[:upper:]' | tr '-' '_')
branch_key=${branch_key:+_$branch_key}

branch_escaped=$(printf '%s' "$branch" | sed 's/[&/\]/\\&/g')

# --- Destinations ---
WORKFLOW_DEST="${WORKFLOWS_DIR}/continuous-deployment${branch_slug}.yml"
DEPLOY_DEST="deploy.sh"

# --- Pre-flight checks ---
if [ -f "$WORKFLOW_DEST" ]; then
	printf "${CLR_DANGER}Error: '$WORKFLOW_DEST' already exists. Aborting.${CLR_RESET}\n" >&2
	exit 1
fi

if [ -f "$DEPLOY_DEST" ]; then
	printf "${CLR_DANGER}Error: '$DEPLOY_DEST' already exists. Aborting.${CLR_RESET}\n" >&2
	exit 1
fi

# --- Create workflows directory if needed ---
mkdir -p "$WORKFLOWS_DIR"

# --- Download workflow and replace placeholders ---
printf "Downloading workflow file...\n"
curl -fsSL "${GIST_RAW}/${WORKFLOW_SRC}?_=$(date +%s)" |
	sed "s/{branch}/${branch_escaped}/g;
         s/\bHOST\b/HOST${branch_key}/g;
         s/\bPORT\b/PORT${branch_key}/g;
         s/\bUSERNAME\b/USERNAME${branch_key}/g;
         s/\bBASE_PATH\b/BASE_PATH${branch_key}/g" >"$WORKFLOW_DEST"

if [ $? -ne 0 ]; then
	printf "${CLR_DANGER}Error: Failed to download workflow file.${CLR_RESET}\n" >&2
	rm -f "$WORKFLOW_DEST"
	exit 1
fi

printf "Saved workflow to '$WORKFLOW_DEST'.\n"

# --- Download deploy.sh ---
printf "Downloading deploy.sh...\n"
curl -fsSL "${GIST_RAW}/${DEPLOY_SRC}?_=$(date +%s)" -o "$DEPLOY_DEST"

if [ $? -ne 0 ]; then
	printf "${CLR_DANGER}Error: Failed to download deploy.sh.${CLR_RESET}\n" >&2
	rm -f "$DEPLOY_DEST"
	exit 1
fi

chmod +x "$DEPLOY_DEST"
printf "Saved deploy script to '$DEPLOY_DEST'.\n"

# --- Summary ---
printf "\n${CLR_BOX}Setup complete for branch '%s'.${CLR_RESET}\n" "$branch"
printf "\nConfigure the following in GitHub → Settings → Secrets and Variables → Actions:\n"
printf "  Secret  : SSH_KEY%s\n" "$branch_key"
printf "  Variable: HOST%s\n" "$branch_key"
printf "  Variable: PORT%s\n" "$branch_key"
printf "  Variable: USERNAME%s\n" "$branch_key"
printf "  Variable: BASE_PATH%s\n" "$branch_key"
