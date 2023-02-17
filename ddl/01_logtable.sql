create table if not exists wa_action_log(
    user varchar(100),
    login varchar(100),
    createtime datetime default now(),
    action varchar(255),
    comment varchar(255),
    primary key (login,createtime)
)