"echo git clone https://aur.archlinux.org/optomizer.git
cd optomizer"
git branch -m add-semi-automatic-deployments main
git fetch origin
git branch -u origin/main main
git remote set-head origin -a
