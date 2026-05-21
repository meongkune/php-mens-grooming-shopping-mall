# GitHub 업로드 절차 정리

이 문서는 `C:\xampp\htdocs\shop9` 폴더를 GitHub 원격 저장소에 연결하고 push한 흐름을 정리한 것입니다.

원격 저장소:

```bash
https://github.com/meongkune/php-mens-grooming-shopping-mall.git
```

## 1. Git 저장소 초기화

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 init
```

현재 폴더를 Git 저장소로 초기화했습니다.

`-c safe.directory=C:/xampp/htdocs/shop9` 옵션은 Git이 폴더 소유자 차이 때문에 저장소 사용을 막아서, 해당 명령에서만 이 폴더를 안전한 저장소로 인정하게 한 것입니다.

## 2. Git 사용자 정보 설정

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 config user.name meongkune
git -c safe.directory=C:/xampp/htdocs/shop9 config user.email meongkune@naver.com
```

이 저장소에서 commit할 때 사용할 이름과 이메일을 설정했습니다.

## 3. GitHub 원격 저장소 연결

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 remote add origin https://github.com/meongkune/php-mens-grooming-shopping-mall.git
```

GitHub 저장소를 `origin`이라는 이름으로 연결했습니다.

## 4. 파일 추가 및 첫 commit 생성

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 add .
git -c safe.directory=C:/xampp/htdocs/shop9 commit -m "Initial commit"
```

현재 폴더의 파일들을 Git에 추가하고 첫 commit을 만들었습니다.

## 5. 브랜치 이름을 main으로 변경

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 branch -M main
```

기본 브랜치 이름을 `main`으로 맞췄습니다.

## 6. 첫 push 시도

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 push -u origin main
```

이 명령은 처음에 거절되었습니다.

이유는 GitHub 원격 저장소의 `main` 브랜치에 이미 commit이 있었기 때문입니다. 로컬 저장소에는 그 commit이 없어서 Git이 먼저 원격 내용을 가져와 합치라고 막았습니다.

## 7. 원격 저장소 내용 가져오기

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 pull --rebase origin main --allow-unrelated-histories
```

GitHub에 있던 기존 commit 위에 로컬 commit을 다시 올리기 위해 rebase 방식으로 pull했습니다.

`--allow-unrelated-histories` 옵션은 로컬 저장소와 원격 저장소가 서로 따로 시작된 Git 기록이었기 때문에 필요했습니다.

## 8. 충돌 해결

pull 중 같은 파일이 양쪽에 모두 있어서 충돌이 발생했습니다.

충돌 난 파일들은 현재 로컬 폴더 내용을 기준으로 선택했습니다.

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 checkout --theirs .
git -c safe.directory=C:/xampp/htdocs/shop9 add .
git -c safe.directory=C:/xampp/htdocs/shop9 -c core.editor=true rebase --continue
```

rebase 중에는 `--theirs`가 적용하려던 로컬 commit 쪽 내용을 의미합니다. 그래서 위 명령으로 충돌 파일을 로컬 버전 기준으로 정리했습니다.

## 9. 최종 push

```bash
git -c safe.directory=C:/xampp/htdocs/shop9 push -u origin main
```

원격 저장소의 기존 commit을 먼저 반영한 뒤 다시 push했기 때문에 정상적으로 GitHub에 업로드되었습니다.

