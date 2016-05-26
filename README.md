# Hệ Thống quản lý người dùng

## I. Yêu cầu

### 1. yêu cầu chức năng
xây dựng hệ thống CRUD quản lý người dùng, với các yêu cầu sau:
- hiện thị thông tin người dùng: stt, tên, email, std, avatar
- tác vụ:
	+ thêm người dùng
	+ sửa thông tin
	+ xóa người dùng
### 2. yêu cầu phi  chức năng
- hệ thống thiết kế theo mô hình MVC
- REST api
- hệ thống xây dựng trên nền tảng Codeiniter 2.x
- giao diện dễ nhìn
- nếu có vấn đề phía client, người quản trị phải được thông báo

## II. Phân tích
### 1. user case Model

![alt text][usecase]

[usecase]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/use_case.png?raw=true "use case model"
hình 2.1 biểu đồ use case model

### 3. 2. đặc tả bổ sung:
#### Actor:
+ Manager: người quản trị, thực hiện các thao tác với người dùng

#### Use case:

##### add user
**mô tả:**
đây là phiên làm việc thêm người dùng mới.

Hình 2.2 add user use case

**luồng sự kiện:**\
người quản trị ấn vào nút thêm mới, hệ thống hiện thị form nhập thông tin người dùng, người đùng submit form, hệ thống xác nhận thông tin, thêm người dùng và thông báo kết quả.

**kết quả:**\
nếu ca sử dụng thành công người dung  mới sẽ được thêm và thông báo thành công, nếu có lỗi hệ thống sẽ  thông báo lỗi.

**yêu cầu:**\
email phải duy nhất và đúng định dạng\
số điện thoại phải là các chữ số\
avatar phải là file ảnh, kích thước bị giới hạn

**ngoại lệ**
- email đã tồn tại: thông báo lỗi
- dữ liệu sai định dạng: thông báo lỗi, chỉ ra các trường chưa đúng
- không thể thêm người dùng: báo lỗi không thể thêm người dùng

##### delete user 
**mô tả:**\
đây là ca sử dụng xóa người dùng

**luồng sự kiện**\
người quản trị ấn vào nút xóa, trong mục action của người dùng. hệ thống thực hiện xóa người dùng và thông báo kết quả.

**kết quả:**\
nếu ca sử dụng thành công thông tin người dùng sẽ bị xóa khỏi database, và thông báo thành công

**yêu cầu**\
người dùng tồn tại\

**ngoại lệ**
- người dùng không tồn tại: thông báo nguwoif dùng không tồn tại\
- xóa không thành công: thông báo không thể xóa người dùng\

##### edit user 

**mô tả**\
đây là ca sử dụng sửa thông tin người dùng

**luồng sự kiện**\
người quản trị ấn vào nút edit, hệ thống hiện thị form edit người dùng, người quản trị submit thông tin người dùng, hệ thống kiểm tra thông tin, lưu lại và thông báo kết quả.

**kết quả**\
nếu ca sử dụng thành công, thông tin người dùng sẽ được thay đổi và thông báo thành công

**yêu cầu**\
email phải duy nhất và đúng định dạng\
số điện thoại phải là các chữ số\
avatar phải là file ảnh, kích thước bị giới hạn

**ngoại lệ**
- email đã tồn tại: thông báo lỗi
- dữ liệu sai định dạng: thông báo lỗi, chỉ ra các trường chưa đúng
- không thể thêm người dùng: báo lỗi không thể sửa thông tin người dùng

##### list user

**mô tả:**\
đây là ca sử dụng hiện thị danh sách người dùng

**luồng sự kiện:**\
người quản trị gửi yêu cầu xem danh sách người dùng, hệ thống trả lại danh sách người dùng

**kết quả:**\
nếu ca sử dụng thành công hệ thống trả lại danh sách người dùng
**yêu cầu**\  
giao diện có nút add user\
thông tin hiện thị dưới dạng bảng, mỗi dòng là một user\ 
có phân trang\
mỗi user phải có các trường: tên, email, sđt, avatar\
với mỗi user có các tác vụ sủa thông tin và xóa\

**ngoại lệ**
- danh sách trống: thông báo không có user\
- user không có avatar: hiện thị avatar mặc định

## III. Thiết kế

### 1. thiết kế use case

#### add user
biểu đồ tuần tự 

![alt text][adduser]

[adduser]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/add_user_sequence.png?raw=true "add user"

hình 3.1 biểu đò tuần tự add user

#### list user


![alt text][listuser]

[listuser]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/list_user_sequence.png?raw=true "list user"
hình 3.2 biểu đồ tuần tự list user

#### edit user 

![alt text][edituser]

[edituser]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/edit_user_sequence.png?raw=true "list user"

hình 3.3 biểu đồ tuần tự edit user 

#### delete user 

![alt text][deleteuser]

[deleteuser]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/delete_user_sequence.png?raw=true "list user"
hình 3.4 biểu đồ tuần tự delete user 

### 2. tổng quan hệ thống

![alt text][system]

[system]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/system_overview.png?raw=true "list user"
hình 3.5 biểu đồ thiết kế hệ thống

### 3. thiết ké đatabase

![alt text][data]

[data]: https://github.com/minhlucvan/enkulu-task/blob/master/docs/database.png?raw=true "list user"
hình 3.6 sơ đồ thiết kế data base 