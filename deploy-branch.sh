
git add .

read -p "Enter commit name: " x

git commit -m "${x}"

read -p "Enter branch name: " y

git push -u origin "${y}"
