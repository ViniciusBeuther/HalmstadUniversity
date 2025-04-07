package Assignment_01.Question_08;

public class Main {
    public static void main(String[] args){
        MessageQueue mq = new MessageQueue(2);
        System.out.println(mq.getCapacity());
        Message m1 = new Message("This is my message 01");
        Message m2 = new Message("This is my message 02");
        Message m3 = new Message("This is my message 03");
        Message m4 = new Message("This is my message 04");
        Message m5 = new Message("This is my message 05");

        mq.add(m1);
        mq.add(m2);
        System.out.println(mq.getCapacity());
        mq.add(m3);
        System.out.println(mq.getCapacity());
        mq.add(m4);
        System.out.println(mq.getCapacity());
        mq.add(m5);

        System.out.println(mq.getCapacity());
        System.out.println(mq.getFirst());
    }
}
