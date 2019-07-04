insert into `article` (`user_id`,`sorts_id`,`title`,`content`,`cdate`,`udate`,`is_show`)
select `user_id`,`sorts_id`,`title`,`content`,`cdate`,`udate`,`is_show`
from `article`;

-- VALUES (null,1,1,'title','content','2018-03-28 16:05:08','2018-03-28 16:05:08',1);


insert into `posts` (`article_id`,`posts_id`,`content`,`date`,`ip`,`is_show`) VALUES
select (`article_id`,`posts_id`,`content`,`date`,`ip`,`is_show`)
from `posts`;


-- (1,0,'content','2018-03-28 16:05:08','1',1)







